<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\Messages as ChildMessages;
use Montanari\Propel\MessagesQuery as ChildMessagesQuery;
use Montanari\Propel\Map\MessagesTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'messages' table.
 *
 *
 *
 * @method     ChildMessagesQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildMessagesQuery orderByIdUserFrom($order = Criteria::ASC) Order by the id_user_from column
 * @method     ChildMessagesQuery orderByIdUserTo($order = Criteria::ASC) Order by the id_user_to column
 * @method     ChildMessagesQuery orderByMessage($order = Criteria::ASC) Order by the message column
 * @method     ChildMessagesQuery orderByRead($order = Criteria::ASC) Order by the read column
 * @method     ChildMessagesQuery orderByDelete($order = Criteria::ASC) Order by the delete column
 * @method     ChildMessagesQuery orderByInsertDate($order = Criteria::ASC) Order by the insert_date column
 * @method     ChildMessagesQuery orderByType($order = Criteria::ASC) Order by the type column
 * @method     ChildMessagesQuery orderBySubject($order = Criteria::ASC) Order by the subject column
 * @method     ChildMessagesQuery orderByParent($order = Criteria::ASC) Order by the parent column
 *
 * @method     ChildMessagesQuery groupById() Group by the id column
 * @method     ChildMessagesQuery groupByIdUserFrom() Group by the id_user_from column
 * @method     ChildMessagesQuery groupByIdUserTo() Group by the id_user_to column
 * @method     ChildMessagesQuery groupByMessage() Group by the message column
 * @method     ChildMessagesQuery groupByRead() Group by the read column
 * @method     ChildMessagesQuery groupByDelete() Group by the delete column
 * @method     ChildMessagesQuery groupByInsertDate() Group by the insert_date column
 * @method     ChildMessagesQuery groupByType() Group by the type column
 * @method     ChildMessagesQuery groupBySubject() Group by the subject column
 * @method     ChildMessagesQuery groupByParent() Group by the parent column
 *
 * @method     ChildMessagesQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildMessagesQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildMessagesQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildMessagesQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildMessagesQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildMessagesQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildMessagesQuery leftJoinUserFrom($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserFrom relation
 * @method     ChildMessagesQuery rightJoinUserFrom($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserFrom relation
 * @method     ChildMessagesQuery innerJoinUserFrom($relationAlias = null) Adds a INNER JOIN clause to the query using the UserFrom relation
 *
 * @method     ChildMessagesQuery joinWithUserFrom($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserFrom relation
 *
 * @method     ChildMessagesQuery leftJoinWithUserFrom() Adds a LEFT JOIN clause and with to the query using the UserFrom relation
 * @method     ChildMessagesQuery rightJoinWithUserFrom() Adds a RIGHT JOIN clause and with to the query using the UserFrom relation
 * @method     ChildMessagesQuery innerJoinWithUserFrom() Adds a INNER JOIN clause and with to the query using the UserFrom relation
 *
 * @method     ChildMessagesQuery leftJoinUserTo($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserTo relation
 * @method     ChildMessagesQuery rightJoinUserTo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserTo relation
 * @method     ChildMessagesQuery innerJoinUserTo($relationAlias = null) Adds a INNER JOIN clause to the query using the UserTo relation
 *
 * @method     ChildMessagesQuery joinWithUserTo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserTo relation
 *
 * @method     ChildMessagesQuery leftJoinWithUserTo() Adds a LEFT JOIN clause and with to the query using the UserTo relation
 * @method     ChildMessagesQuery rightJoinWithUserTo() Adds a RIGHT JOIN clause and with to the query using the UserTo relation
 * @method     ChildMessagesQuery innerJoinWithUserTo() Adds a INNER JOIN clause and with to the query using the UserTo relation
 *
 * @method     ChildMessagesQuery leftJoinParentTo($relationAlias = null) Adds a LEFT JOIN clause to the query using the ParentTo relation
 * @method     ChildMessagesQuery rightJoinParentTo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ParentTo relation
 * @method     ChildMessagesQuery innerJoinParentTo($relationAlias = null) Adds a INNER JOIN clause to the query using the ParentTo relation
 *
 * @method     ChildMessagesQuery joinWithParentTo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the ParentTo relation
 *
 * @method     ChildMessagesQuery leftJoinWithParentTo() Adds a LEFT JOIN clause and with to the query using the ParentTo relation
 * @method     ChildMessagesQuery rightJoinWithParentTo() Adds a RIGHT JOIN clause and with to the query using the ParentTo relation
 * @method     ChildMessagesQuery innerJoinWithParentTo() Adds a INNER JOIN clause and with to the query using the ParentTo relation
 *
 * @method     ChildMessagesQuery leftJoinMessagesRelatedById($relationAlias = null) Adds a LEFT JOIN clause to the query using the MessagesRelatedById relation
 * @method     ChildMessagesQuery rightJoinMessagesRelatedById($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MessagesRelatedById relation
 * @method     ChildMessagesQuery innerJoinMessagesRelatedById($relationAlias = null) Adds a INNER JOIN clause to the query using the MessagesRelatedById relation
 *
 * @method     ChildMessagesQuery joinWithMessagesRelatedById($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MessagesRelatedById relation
 *
 * @method     ChildMessagesQuery leftJoinWithMessagesRelatedById() Adds a LEFT JOIN clause and with to the query using the MessagesRelatedById relation
 * @method     ChildMessagesQuery rightJoinWithMessagesRelatedById() Adds a RIGHT JOIN clause and with to the query using the MessagesRelatedById relation
 * @method     ChildMessagesQuery innerJoinWithMessagesRelatedById() Adds a INNER JOIN clause and with to the query using the MessagesRelatedById relation
 *
 * @method     \Montanari\Propel\UsersQuery|\Montanari\Propel\MessagesQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildMessages findOne(ConnectionInterface $con = null) Return the first ChildMessages matching the query
 * @method     ChildMessages findOneOrCreate(ConnectionInterface $con = null) Return the first ChildMessages matching the query, or a new ChildMessages object populated from the query conditions when no match is found
 *
 * @method     ChildMessages findOneById(string $id) Return the first ChildMessages filtered by the id column
 * @method     ChildMessages findOneByIdUserFrom(int $id_user_from) Return the first ChildMessages filtered by the id_user_from column
 * @method     ChildMessages findOneByIdUserTo(int $id_user_to) Return the first ChildMessages filtered by the id_user_to column
 * @method     ChildMessages findOneByMessage(string $message) Return the first ChildMessages filtered by the message column
 * @method     ChildMessages findOneByRead(boolean $read) Return the first ChildMessages filtered by the read column
 * @method     ChildMessages findOneByDelete(boolean $delete) Return the first ChildMessages filtered by the delete column
 * @method     ChildMessages findOneByInsertDate(string $insert_date) Return the first ChildMessages filtered by the insert_date column
 * @method     ChildMessages findOneByType(string $type) Return the first ChildMessages filtered by the type column
 * @method     ChildMessages findOneBySubject(string $subject) Return the first ChildMessages filtered by the subject column
 * @method     ChildMessages findOneByParent(string $parent) Return the first ChildMessages filtered by the parent column *

 * @method     ChildMessages requirePk($key, ConnectionInterface $con = null) Return the ChildMessages by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOne(ConnectionInterface $con = null) Return the first ChildMessages matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessages requireOneById(string $id) Return the first ChildMessages filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByIdUserFrom(int $id_user_from) Return the first ChildMessages filtered by the id_user_from column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByIdUserTo(int $id_user_to) Return the first ChildMessages filtered by the id_user_to column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByMessage(string $message) Return the first ChildMessages filtered by the message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByRead(boolean $read) Return the first ChildMessages filtered by the read column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByDelete(boolean $delete) Return the first ChildMessages filtered by the delete column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByInsertDate(string $insert_date) Return the first ChildMessages filtered by the insert_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByType(string $type) Return the first ChildMessages filtered by the type column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneBySubject(string $subject) Return the first ChildMessages filtered by the subject column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildMessages requireOneByParent(string $parent) Return the first ChildMessages filtered by the parent column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildMessages[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildMessages objects based on current ModelCriteria
 * @method     ChildMessages[]|ObjectCollection findById(string $id) Return ChildMessages objects filtered by the id column
 * @method     ChildMessages[]|ObjectCollection findByIdUserFrom(int $id_user_from) Return ChildMessages objects filtered by the id_user_from column
 * @method     ChildMessages[]|ObjectCollection findByIdUserTo(int $id_user_to) Return ChildMessages objects filtered by the id_user_to column
 * @method     ChildMessages[]|ObjectCollection findByMessage(string $message) Return ChildMessages objects filtered by the message column
 * @method     ChildMessages[]|ObjectCollection findByRead(boolean $read) Return ChildMessages objects filtered by the read column
 * @method     ChildMessages[]|ObjectCollection findByDelete(boolean $delete) Return ChildMessages objects filtered by the delete column
 * @method     ChildMessages[]|ObjectCollection findByInsertDate(string $insert_date) Return ChildMessages objects filtered by the insert_date column
 * @method     ChildMessages[]|ObjectCollection findByType(string $type) Return ChildMessages objects filtered by the type column
 * @method     ChildMessages[]|ObjectCollection findBySubject(string $subject) Return ChildMessages objects filtered by the subject column
 * @method     ChildMessages[]|ObjectCollection findByParent(string $parent) Return ChildMessages objects filtered by the parent column
 * @method     ChildMessages[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class MessagesQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\MessagesQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\Messages', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildMessagesQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildMessagesQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildMessagesQuery) {
            return $criteria;
        }
        $query = new ChildMessagesQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildMessages|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(MessagesTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = MessagesTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMessages A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT `id`, `id_user_from`, `id_user_to`, `message`, `read`, `delete`, `insert_date`, `type`, `subject`, `parent` FROM `messages` WHERE `id` = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildMessages $obj */
            $obj = new ChildMessages();
            $obj->hydrate($row);
            MessagesTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildMessages|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MessagesTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MessagesTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the id_user_from column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUserFrom(1234); // WHERE id_user_from = 1234
     * $query->filterByIdUserFrom(array(12, 34)); // WHERE id_user_from IN (12, 34)
     * $query->filterByIdUserFrom(array('min' => 12)); // WHERE id_user_from > 12
     * </code>
     *
     * @see       filterByUserFrom()
     *
     * @param     mixed $idUserFrom The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByIdUserFrom($idUserFrom = null, $comparison = null)
    {
        if (is_array($idUserFrom)) {
            $useMinMax = false;
            if (isset($idUserFrom['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_ID_USER_FROM, $idUserFrom['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUserFrom['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_ID_USER_FROM, $idUserFrom['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_ID_USER_FROM, $idUserFrom, $comparison);
    }

    /**
     * Filter the query on the id_user_to column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUserTo(1234); // WHERE id_user_to = 1234
     * $query->filterByIdUserTo(array(12, 34)); // WHERE id_user_to IN (12, 34)
     * $query->filterByIdUserTo(array('min' => 12)); // WHERE id_user_to > 12
     * </code>
     *
     * @see       filterByUserTo()
     *
     * @param     mixed $idUserTo The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByIdUserTo($idUserTo = null, $comparison = null)
    {
        if (is_array($idUserTo)) {
            $useMinMax = false;
            if (isset($idUserTo['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_ID_USER_TO, $idUserTo['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUserTo['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_ID_USER_TO, $idUserTo['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_ID_USER_TO, $idUserTo, $comparison);
    }

    /**
     * Filter the query on the message column
     *
     * Example usage:
     * <code>
     * $query->filterByMessage('fooValue');   // WHERE message = 'fooValue'
     * $query->filterByMessage('%fooValue%', Criteria::LIKE); // WHERE message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $message The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByMessage($message = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($message)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_MESSAGE, $message, $comparison);
    }

    /**
     * Filter the query on the read column
     *
     * Example usage:
     * <code>
     * $query->filterByRead(true); // WHERE read = true
     * $query->filterByRead('yes'); // WHERE read = true
     * </code>
     *
     * @param     boolean|string $read The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByRead($read = null, $comparison = null)
    {
        if (is_string($read)) {
            $read = in_array(strtolower($read), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MessagesTableMap::COL_READ, $read, $comparison);
    }

    /**
     * Filter the query on the delete column
     *
     * Example usage:
     * <code>
     * $query->filterByDelete(true); // WHERE delete = true
     * $query->filterByDelete('yes'); // WHERE delete = true
     * </code>
     *
     * @param     boolean|string $delete The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByDelete($delete = null, $comparison = null)
    {
        if (is_string($delete)) {
            $delete = in_array(strtolower($delete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(MessagesTableMap::COL_DELETE, $delete, $comparison);
    }

    /**
     * Filter the query on the insert_date column
     *
     * Example usage:
     * <code>
     * $query->filterByInsertDate('2011-03-14'); // WHERE insert_date = '2011-03-14'
     * $query->filterByInsertDate('now'); // WHERE insert_date = '2011-03-14'
     * $query->filterByInsertDate(array('max' => 'yesterday')); // WHERE insert_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $insertDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByInsertDate($insertDate = null, $comparison = null)
    {
        if (is_array($insertDate)) {
            $useMinMax = false;
            if (isset($insertDate['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_INSERT_DATE, $insertDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($insertDate['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_INSERT_DATE, $insertDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_INSERT_DATE, $insertDate, $comparison);
    }

    /**
     * Filter the query on the type column
     *
     * Example usage:
     * <code>
     * $query->filterByType('fooValue');   // WHERE type = 'fooValue'
     * $query->filterByType('%fooValue%', Criteria::LIKE); // WHERE type LIKE '%fooValue%'
     * </code>
     *
     * @param     string $type The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByType($type = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($type)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_TYPE, $type, $comparison);
    }

    /**
     * Filter the query on the subject column
     *
     * Example usage:
     * <code>
     * $query->filterBySubject('fooValue');   // WHERE subject = 'fooValue'
     * $query->filterBySubject('%fooValue%', Criteria::LIKE); // WHERE subject LIKE '%fooValue%'
     * </code>
     *
     * @param     string $subject The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterBySubject($subject = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($subject)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_SUBJECT, $subject, $comparison);
    }

    /**
     * Filter the query on the parent column
     *
     * Example usage:
     * <code>
     * $query->filterByParent(1234); // WHERE parent = 1234
     * $query->filterByParent(array(12, 34)); // WHERE parent IN (12, 34)
     * $query->filterByParent(array('min' => 12)); // WHERE parent > 12
     * </code>
     *
     * @see       filterByParentTo()
     *
     * @param     mixed $parent The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByParent($parent = null, $comparison = null)
    {
        if (is_array($parent)) {
            $useMinMax = false;
            if (isset($parent['min'])) {
                $this->addUsingAlias(MessagesTableMap::COL_PARENT, $parent['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($parent['max'])) {
                $this->addUsingAlias(MessagesTableMap::COL_PARENT, $parent['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MessagesTableMap::COL_PARENT, $parent, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\Users object
     *
     * @param \Montanari\Propel\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByUserFrom($users, $comparison = null)
    {
        if ($users instanceof \Montanari\Propel\Users) {
            return $this
                ->addUsingAlias(MessagesTableMap::COL_ID_USER_FROM, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MessagesTableMap::COL_ID_USER_FROM, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserFrom() only accepts arguments of type \Montanari\Propel\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserFrom relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function joinUserFrom($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserFrom');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserFrom');
        }

        return $this;
    }

    /**
     * Use the UserFrom relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUserFromQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserFrom($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserFrom', '\Montanari\Propel\UsersQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Users object
     *
     * @param \Montanari\Propel\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByUserTo($users, $comparison = null)
    {
        if ($users instanceof \Montanari\Propel\Users) {
            return $this
                ->addUsingAlias(MessagesTableMap::COL_ID_USER_TO, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MessagesTableMap::COL_ID_USER_TO, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUserTo() only accepts arguments of type \Montanari\Propel\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserTo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function joinUserTo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserTo');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'UserTo');
        }

        return $this;
    }

    /**
     * Use the UserTo relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUserToQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserTo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserTo', '\Montanari\Propel\UsersQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Messages object
     *
     * @param \Montanari\Propel\Messages|ObjectCollection $messages The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByParentTo($messages, $comparison = null)
    {
        if ($messages instanceof \Montanari\Propel\Messages) {
            return $this
                ->addUsingAlias(MessagesTableMap::COL_PARENT, $messages->getId(), $comparison);
        } elseif ($messages instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MessagesTableMap::COL_PARENT, $messages->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByParentTo() only accepts arguments of type \Montanari\Propel\Messages or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ParentTo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function joinParentTo($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ParentTo');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ParentTo');
        }

        return $this;
    }

    /**
     * Use the ParentTo relation Messages object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\MessagesQuery A secondary query class using the current class as primary query
     */
    public function useParentToQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinParentTo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ParentTo', '\Montanari\Propel\MessagesQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Messages object
     *
     * @param \Montanari\Propel\Messages|ObjectCollection $messages the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildMessagesQuery The current query, for fluid interface
     */
    public function filterByMessagesRelatedById($messages, $comparison = null)
    {
        if ($messages instanceof \Montanari\Propel\Messages) {
            return $this
                ->addUsingAlias(MessagesTableMap::COL_ID, $messages->getParent(), $comparison);
        } elseif ($messages instanceof ObjectCollection) {
            return $this
                ->useMessagesRelatedByIdQuery()
                ->filterByPrimaryKeys($messages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessagesRelatedById() only accepts arguments of type \Montanari\Propel\Messages or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MessagesRelatedById relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function joinMessagesRelatedById($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MessagesRelatedById');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'MessagesRelatedById');
        }

        return $this;
    }

    /**
     * Use the MessagesRelatedById relation Messages object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\MessagesQuery A secondary query class using the current class as primary query
     */
    public function useMessagesRelatedByIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinMessagesRelatedById($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MessagesRelatedById', '\Montanari\Propel\MessagesQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildMessages $messages Object to remove from the list of results
     *
     * @return $this|ChildMessagesQuery The current query, for fluid interface
     */
    public function prune($messages = null)
    {
        if ($messages) {
            $this->addUsingAlias(MessagesTableMap::COL_ID, $messages->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the messages table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            MessagesTableMap::clearInstancePool();
            MessagesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(MessagesTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            MessagesTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            MessagesTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // MessagesQuery
