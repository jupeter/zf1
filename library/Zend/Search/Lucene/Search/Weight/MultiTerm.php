<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */


/** Zend_Search_Lucene_Search_Weight */
require_once 'Zend/Search/Lucene/Search/Weight.php';


/**
 * @package    Zend_Search_Lucene
 * @subpackage Search
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Search_Lucene_Search_Weight_MultiTerm extends Zend_Search_Lucene_Search_Weight
{
    /**
     * IndexReader.
     *
     * @var Zend_Search_Lucene
     */
    private $_reader;

    /**
     * The query that this concerns.
     *
     * @var Zend_Search_Lucene_Search_Query_MultiTerm
     */
    private $_query;

    /**
     * Query terms weights
     * Array of Zend_Search_Lucene_Search_Weight_Term
     *
     * @var array
     */
    private $_weights;


    /**
     * Zend_Search_Lucene_Search_Weight_MultiTerm constructor
     * query - the query that this concerns.
     * reader - index reader
     *
     * @param Zend_Search_Lucene_Search_Query_MultiTerm $query
     * @param Zend_Search_Lucene $reader
     */
    public function __construct($query, $reader)
    {
        $this->_query   = $query;
        $this->_reader  = $reader;
        $this->_weights = array();

        $signs = $query->getSigns();

        foreach ($query->getTerms() as $num => $term) {
            if ($signs === null || $signs[$num] === null || $signs[$num]) {
                $this->_weights[$num] = new Zend_Search_Lucene_Search_Weight_Term($term, $query, $reader);
                $query->setWeight($num, $this->_weights[$num]);
            }
        }
    }


    /**
     * The weight for this query
     *
     * @return float
     */
    public function getValue()
    {
        return $this->_query->getBoost();
    }


    /**
     * The sum of squared weights of contained query clauses.
     *
     * @return float
     */
    public function sumOfSquaredWeights()
    {
        $sum = 0;
        foreach ($this->_weights as $weight) {
            // sum sub weights
            $sum += $weight->sumOfSquaredWeights();
        }

        // boost each sub-weight
        $sum *= $this->_query->getBoost() * $this->_query->getBoost();

        // check for empty query (like '-something -another')
        if ($sum == 0) {
            $sum = 1.0;
        }
        return $sum;
    }


    /**
     * Assigns the query normalization factor to this.
     *
     * @param float $queryNorm
     */
    public function normalize($queryNorm)
    {
        // incorporate boost
        $queryNorm *= $this->_query->getBoost();

        foreach ($this->_weights as $weight) {
            $weight->normalize($queryNorm);
        }
    }
}


