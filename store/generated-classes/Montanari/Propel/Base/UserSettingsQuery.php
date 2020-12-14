<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\UserSettings as ChildUserSettings;
use Montanari\Propel\UserSettingsQuery as ChildUserSettingsQuery;
use Montanari\Propel\Map\UserSettingsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'user_settings' table.
 *
 *
 *
 * @method     ChildUserSettingsQuery orderByIdUser($order = Criteria::ASC) Order by the id_user column
 * @method     ChildUserSettingsQuery orderByPushMessage($order = Criteria::ASC) Order by the push_message column
 * @method     ChildUserSettingsQuery orderByEmailMessage($order = Criteria::ASC) Order by the email_message column
 * @method     ChildUserSettingsQuery orderByEmailCarSummary($order = Criteria::ASC) Order by the email_car_summary column
 * @method     ChildUserSettingsQuery orderByEmailEventSummary($order = Criteria::ASC) Order by the email_event_summary column
 *
 * @method     ChildUserSettingsQuery groupByIdUser() Group by the id_user column
 * @method     ChildUserSettingsQuery groupByPushMessage() Group by the push_message column
 * @method     ChildUserSettingsQuery groupByEmailMessage() Group by the email_message column
 * @method     ChildUserSettingsQuery groupByEmailCarSummary() Group by the email_car_summary column
 * @method     ChildUserSettingsQuery groupByEmailEventSummary() Group by the email_event_summary column
 *
 * @method     ChildUserSettingsQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUserSettingsQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUserSettingsQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUserSettingsQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUserSettingsQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUserSettingsQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUserSettingsQuery leftJoinUsers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Users relation
 * @method     ChildUserSettingsQuery rightJoinUsers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Users relation
 * @method     ChildUserSettingsQuery innerJoinUsers($relationAlias = null) Adds a INNER JOIN clause to the query using the Users relation
 *
 * @method     ChildUserSettingsQuery joinWithUsers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Users relation
 *
 * @method     ChildUserSettingsQuery leftJoinWithUsers() Adds a LEFT JOIN clause and with to the query using the Users relation
 * @method     ChildUserSettingsQuery rightJoinWithUsers() Adds a RIGHT JOIN clause and with to the query using the Users relation
 * @method     ChildUserSettingsQuery innerJoinWithUsers() Adds a INNER JOIN clause and with to the query using the Users relation
 *
 * @method     \Montanari\Propel\UsersQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUserSettings findOne(ConnectionInterface $con = null) Return the first ChildUserSettings matching the query
 * @method     ChildUserSettings findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUserSettings matching the query, or a new ChildUserSettings object populated from the query conditions when no match is found
 *
 * @method     ChildUserSettings findOneByIdUser(int $id_user) Return the first ChildUserSettings filtered by the id_user column
 * @method     ChildUserSettings findOneByPushMessage(string $push_message) Return the first ChildUserSettings filtered by the push_message column
 * @method     ChildUserSettings findOneByEmailMessage(string $email_message) Return the first ChildUserSettings filtered by the email_message column
 * @method     ChildUserSettings findOneByEmailCarSummary(string $email_car_summary) Return the first ChildUserSettings filtered by the email_car_summary column
 * @method     ChildUserSettings findOneByEmailEventSummary(string $email_event_summary) Return the first ChildUserSettings filtered by the email_event_summary column *

 * @method     ChildUserSettings requirePk($key, ConnectionInterface $con = null) Return the ChildUserSettings by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSettings requireOne(ConnectionInterface $con = null) Return the first ChildUserSettings matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserSettings requireOneByIdUser(int $id_user) Return the first ChildUserSettings filtered by the id_user column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSettings requireOneByPushMessage(string $push_message) Return the first ChildUserSettings filtered by the push_message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSettings requireOneByEmailMessage(string $email_message) Return the first ChildUserSettings filtered by the email_message column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSettings requireOneByEmailCarSummary(string $email_car_summary) Return the first ChildUserSettings filtered by the email_car_summary column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUserSettings requireOneByEmailEventSummary(string $email_event_summary) Return the first ChildUserSettings filtered by the email_event_summary column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUserSettings[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUserSettings objects based on current ModelCriteria
 * @method     ChildUserSettings[]|ObjectCollection findByIdUser(int $id_user) Return ChildUserSettings objects filtered by the id_user column
 * @method     ChildUserSettings[]|ObjectCollection findByPushMessage(string $push_message) Return ChildUserSettings objects filtered by the push_message column
 * @method     ChildUserSettings[]|ObjectCollection findByEmailMessage(string $email_message) Return ChildUserSettings objects filtered by the email_message column
 * @method     ChildUserSettings[]|ObjectCollection findByEmailCarSummary(string $email_car_summary) Return ChildUserSettings objects filtered by the email_car_summary column
 * @method     ChildUserSettings[]|ObjectCollection findByEmailEventSummary(string $email_event_summary) Return ChildUserSettings objects filtered by the email_event_summary column
 * @method     ChildUserSettings[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UserSettingsQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\UserSettingsQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\UserSettings', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUserSettingsQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUserSettingsQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUserSettingsQuery) {
            return $criteria;
        }
        $query = new ChildUserSettingsQuery();
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
     * @return ChildUserSettings|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UserSettingsTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UserSettingsTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUserSettings A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id_user, push_message, email_message, email_car_summary, email_event_summary FROM user_settings WHERE id_user = :p0';
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
            /** @var ChildUserSettings $obj */
            $obj = new ChildUserSettings();
            $obj->hydrate($row);
            UserSettingsTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUserSettings|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id_user column
     *
     * Example usage:
     * <code>
     * $query->filterByIdUser(1234); // WHERE id_user = 1234
     * $query->filterByIdUser(array(12, 34)); // WHERE id_user IN (12, 34)
     * $query->filterByIdUser(array('min' => 12)); // WHERE id_user > 12
     * </code>
     *
     * @see       filterByUsers()
     *
     * @param     mixed $idUser The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByIdUser($idUser = null, $comparison = null)
    {
        if (is_array($idUser)) {
            $useMinMax = false;
            if (isset($idUser['min'])) {
                $this->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $idUser['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idUser['max'])) {
                $this->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $idUser['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $idUser, $comparison);
    }

    /**
     * Filter the query on the push_message column
     *
     * Example usage:
     * <code>
     * $query->filterByPushMessage('fooValue');   // WHERE push_message = 'fooValue'
     * $query->filterByPushMessage('%fooValue%', Criteria::LIKE); // WHERE push_message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pushMessage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByPushMessage($pushMessage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pushMessage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSettingsTableMap::COL_PUSH_MESSAGE, $pushMessage, $comparison);
    }

    /**
     * Filter the query on the email_message column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailMessage('fooValue');   // WHERE email_message = 'fooValue'
     * $query->filterByEmailMessage('%fooValue%', Criteria::LIKE); // WHERE email_message LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailMessage The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByEmailMessage($emailMessage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailMessage)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSettingsTableMap::COL_EMAIL_MESSAGE, $emailMessage, $comparison);
    }

    /**
     * Filter the query on the email_car_summary column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailCarSummary('fooValue');   // WHERE email_car_summary = 'fooValue'
     * $query->filterByEmailCarSummary('%fooValue%', Criteria::LIKE); // WHERE email_car_summary LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailCarSummary The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByEmailCarSummary($emailCarSummary = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailCarSummary)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSettingsTableMap::COL_EMAIL_CAR_SUMMARY, $emailCarSummary, $comparison);
    }

    /**
     * Filter the query on the email_event_summary column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailEventSummary('fooValue');   // WHERE email_event_summary = 'fooValue'
     * $query->filterByEmailEventSummary('%fooValue%', Criteria::LIKE); // WHERE email_event_summary LIKE '%fooValue%'
     * </code>
     *
     * @param     string $emailEventSummary The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByEmailEventSummary($emailEventSummary = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($emailEventSummary)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UserSettingsTableMap::COL_EMAIL_EVENT_SUMMARY, $emailEventSummary, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\Users object
     *
     * @param \Montanari\Propel\Users|ObjectCollection $users The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildUserSettingsQuery The current query, for fluid interface
     */
    public function filterByUsers($users, $comparison = null)
    {
        if ($users instanceof \Montanari\Propel\Users) {
            return $this
                ->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $users->getId(), $comparison);
        } elseif ($users instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $users->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByUsers() only accepts arguments of type \Montanari\Propel\Users or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Users relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function joinUsers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Users');

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
            $this->addJoinObject($join, 'Users');
        }

        return $this;
    }

    /**
     * Use the Users relation Users object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\UsersQuery A secondary query class using the current class as primary query
     */
    public function useUsersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUsers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Users', '\Montanari\Propel\UsersQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUserSettings $userSettings Object to remove from the list of results
     *
     * @return $this|ChildUserSettingsQuery The current query, for fluid interface
     */
    public function prune($userSettings = null)
    {
        if ($userSettings) {
            $this->addUsingAlias(UserSettingsTableMap::COL_ID_USER, $userSettings->getIdUser(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the user_settings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UserSettingsTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UserSettingsTableMap::clearInstancePool();
            UserSettingsTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UserSettingsTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UserSettingsTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UserSettingsTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UserSettingsTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UserSettingsQuery
