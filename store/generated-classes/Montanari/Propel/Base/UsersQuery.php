<?php

namespace Montanari\Propel\Base;

use \Exception;
use \PDO;
use Montanari\Propel\Users as ChildUsers;
use Montanari\Propel\UsersQuery as ChildUsersQuery;
use Montanari\Propel\Map\UsersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'users' table.
 *
 *
 *
 * @method     ChildUsersQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildUsersQuery orderByUsername($order = Criteria::ASC) Order by the username column
 * @method     ChildUsersQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildUsersQuery orderByCognome($order = Criteria::ASC) Order by the cognome column
 * @method     ChildUsersQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildUsersQuery orderByAbitazione($order = Criteria::ASC) Order by the abitazione column
 * @method     ChildUsersQuery orderByAutonomia($order = Criteria::ASC) Order by the autonomia column
 * @method     ChildUsersQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildUsersQuery orderByIdPlayerNotifiche($order = Criteria::ASC) Order by the id_player_notifiche column
 * @method     ChildUsersQuery orderByInsertDate($order = Criteria::ASC) Order by the insert_date column
 * @method     ChildUsersQuery orderByEmailConfirm($order = Criteria::ASC) Order by the email_confirm column
 * @method     ChildUsersQuery orderByFirstAccess($order = Criteria::ASC) Order by the first_access column
 * @method     ChildUsersQuery orderByCodeConfirm($order = Criteria::ASC) Order by the code_confirm column
 *
 * @method     ChildUsersQuery groupById() Group by the id column
 * @method     ChildUsersQuery groupByUsername() Group by the username column
 * @method     ChildUsersQuery groupByNome() Group by the nome column
 * @method     ChildUsersQuery groupByCognome() Group by the cognome column
 * @method     ChildUsersQuery groupByPassword() Group by the password column
 * @method     ChildUsersQuery groupByAbitazione() Group by the abitazione column
 * @method     ChildUsersQuery groupByAutonomia() Group by the autonomia column
 * @method     ChildUsersQuery groupByEmail() Group by the email column
 * @method     ChildUsersQuery groupByIdPlayerNotifiche() Group by the id_player_notifiche column
 * @method     ChildUsersQuery groupByInsertDate() Group by the insert_date column
 * @method     ChildUsersQuery groupByEmailConfirm() Group by the email_confirm column
 * @method     ChildUsersQuery groupByFirstAccess() Group by the first_access column
 * @method     ChildUsersQuery groupByCodeConfirm() Group by the code_confirm column
 *
 * @method     ChildUsersQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildUsersQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildUsersQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildUsersQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildUsersQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildUsersQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildUsersQuery leftJoinDrivers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Drivers relation
 * @method     ChildUsersQuery rightJoinDrivers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Drivers relation
 * @method     ChildUsersQuery innerJoinDrivers($relationAlias = null) Adds a INNER JOIN clause to the query using the Drivers relation
 *
 * @method     ChildUsersQuery joinWithDrivers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Drivers relation
 *
 * @method     ChildUsersQuery leftJoinWithDrivers() Adds a LEFT JOIN clause and with to the query using the Drivers relation
 * @method     ChildUsersQuery rightJoinWithDrivers() Adds a RIGHT JOIN clause and with to the query using the Drivers relation
 * @method     ChildUsersQuery innerJoinWithDrivers() Adds a INNER JOIN clause and with to the query using the Drivers relation
 *
 * @method     ChildUsersQuery leftJoinMessagesRelatedByIdUserFrom($relationAlias = null) Adds a LEFT JOIN clause to the query using the MessagesRelatedByIdUserFrom relation
 * @method     ChildUsersQuery rightJoinMessagesRelatedByIdUserFrom($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MessagesRelatedByIdUserFrom relation
 * @method     ChildUsersQuery innerJoinMessagesRelatedByIdUserFrom($relationAlias = null) Adds a INNER JOIN clause to the query using the MessagesRelatedByIdUserFrom relation
 *
 * @method     ChildUsersQuery joinWithMessagesRelatedByIdUserFrom($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MessagesRelatedByIdUserFrom relation
 *
 * @method     ChildUsersQuery leftJoinWithMessagesRelatedByIdUserFrom() Adds a LEFT JOIN clause and with to the query using the MessagesRelatedByIdUserFrom relation
 * @method     ChildUsersQuery rightJoinWithMessagesRelatedByIdUserFrom() Adds a RIGHT JOIN clause and with to the query using the MessagesRelatedByIdUserFrom relation
 * @method     ChildUsersQuery innerJoinWithMessagesRelatedByIdUserFrom() Adds a INNER JOIN clause and with to the query using the MessagesRelatedByIdUserFrom relation
 *
 * @method     ChildUsersQuery leftJoinMessagesRelatedByIdUserTo($relationAlias = null) Adds a LEFT JOIN clause to the query using the MessagesRelatedByIdUserTo relation
 * @method     ChildUsersQuery rightJoinMessagesRelatedByIdUserTo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the MessagesRelatedByIdUserTo relation
 * @method     ChildUsersQuery innerJoinMessagesRelatedByIdUserTo($relationAlias = null) Adds a INNER JOIN clause to the query using the MessagesRelatedByIdUserTo relation
 *
 * @method     ChildUsersQuery joinWithMessagesRelatedByIdUserTo($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the MessagesRelatedByIdUserTo relation
 *
 * @method     ChildUsersQuery leftJoinWithMessagesRelatedByIdUserTo() Adds a LEFT JOIN clause and with to the query using the MessagesRelatedByIdUserTo relation
 * @method     ChildUsersQuery rightJoinWithMessagesRelatedByIdUserTo() Adds a RIGHT JOIN clause and with to the query using the MessagesRelatedByIdUserTo relation
 * @method     ChildUsersQuery innerJoinWithMessagesRelatedByIdUserTo() Adds a INNER JOIN clause and with to the query using the MessagesRelatedByIdUserTo relation
 *
 * @method     ChildUsersQuery leftJoinPassengers($relationAlias = null) Adds a LEFT JOIN clause to the query using the Passengers relation
 * @method     ChildUsersQuery rightJoinPassengers($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Passengers relation
 * @method     ChildUsersQuery innerJoinPassengers($relationAlias = null) Adds a INNER JOIN clause to the query using the Passengers relation
 *
 * @method     ChildUsersQuery joinWithPassengers($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Passengers relation
 *
 * @method     ChildUsersQuery leftJoinWithPassengers() Adds a LEFT JOIN clause and with to the query using the Passengers relation
 * @method     ChildUsersQuery rightJoinWithPassengers() Adds a RIGHT JOIN clause and with to the query using the Passengers relation
 * @method     ChildUsersQuery innerJoinWithPassengers() Adds a INNER JOIN clause and with to the query using the Passengers relation
 *
 * @method     ChildUsersQuery leftJoinUserSettings($relationAlias = null) Adds a LEFT JOIN clause to the query using the UserSettings relation
 * @method     ChildUsersQuery rightJoinUserSettings($relationAlias = null) Adds a RIGHT JOIN clause to the query using the UserSettings relation
 * @method     ChildUsersQuery innerJoinUserSettings($relationAlias = null) Adds a INNER JOIN clause to the query using the UserSettings relation
 *
 * @method     ChildUsersQuery joinWithUserSettings($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the UserSettings relation
 *
 * @method     ChildUsersQuery leftJoinWithUserSettings() Adds a LEFT JOIN clause and with to the query using the UserSettings relation
 * @method     ChildUsersQuery rightJoinWithUserSettings() Adds a RIGHT JOIN clause and with to the query using the UserSettings relation
 * @method     ChildUsersQuery innerJoinWithUserSettings() Adds a INNER JOIN clause and with to the query using the UserSettings relation
 *
 * @method     \Montanari\Propel\DriversQuery|\Montanari\Propel\MessagesQuery|\Montanari\Propel\PassengersQuery|\Montanari\Propel\UserSettingsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildUsers findOne(ConnectionInterface $con = null) Return the first ChildUsers matching the query
 * @method     ChildUsers findOneOrCreate(ConnectionInterface $con = null) Return the first ChildUsers matching the query, or a new ChildUsers object populated from the query conditions when no match is found
 *
 * @method     ChildUsers findOneById(int $id) Return the first ChildUsers filtered by the id column
 * @method     ChildUsers findOneByUsername(string $username) Return the first ChildUsers filtered by the username column
 * @method     ChildUsers findOneByNome(string $nome) Return the first ChildUsers filtered by the nome column
 * @method     ChildUsers findOneByCognome(string $cognome) Return the first ChildUsers filtered by the cognome column
 * @method     ChildUsers findOneByPassword(string $password) Return the first ChildUsers filtered by the password column
 * @method     ChildUsers findOneByAbitazione(string $abitazione) Return the first ChildUsers filtered by the abitazione column
 * @method     ChildUsers findOneByAutonomia(boolean $autonomia) Return the first ChildUsers filtered by the autonomia column
 * @method     ChildUsers findOneByEmail(string $email) Return the first ChildUsers filtered by the email column
 * @method     ChildUsers findOneByIdPlayerNotifiche(string $id_player_notifiche) Return the first ChildUsers filtered by the id_player_notifiche column
 * @method     ChildUsers findOneByInsertDate(string $insert_date) Return the first ChildUsers filtered by the insert_date column
 * @method     ChildUsers findOneByEmailConfirm(boolean $email_confirm) Return the first ChildUsers filtered by the email_confirm column
 * @method     ChildUsers findOneByFirstAccess(boolean $first_access) Return the first ChildUsers filtered by the first_access column
 * @method     ChildUsers findOneByCodeConfirm(string $code_confirm) Return the first ChildUsers filtered by the code_confirm column *

 * @method     ChildUsers requirePk($key, ConnectionInterface $con = null) Return the ChildUsers by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOne(ConnectionInterface $con = null) Return the first ChildUsers matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsers requireOneById(int $id) Return the first ChildUsers filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByUsername(string $username) Return the first ChildUsers filtered by the username column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByNome(string $nome) Return the first ChildUsers filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByCognome(string $cognome) Return the first ChildUsers filtered by the cognome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByPassword(string $password) Return the first ChildUsers filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByAbitazione(string $abitazione) Return the first ChildUsers filtered by the abitazione column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByAutonomia(boolean $autonomia) Return the first ChildUsers filtered by the autonomia column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByEmail(string $email) Return the first ChildUsers filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByIdPlayerNotifiche(string $id_player_notifiche) Return the first ChildUsers filtered by the id_player_notifiche column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByInsertDate(string $insert_date) Return the first ChildUsers filtered by the insert_date column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByEmailConfirm(boolean $email_confirm) Return the first ChildUsers filtered by the email_confirm column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByFirstAccess(boolean $first_access) Return the first ChildUsers filtered by the first_access column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildUsers requireOneByCodeConfirm(string $code_confirm) Return the first ChildUsers filtered by the code_confirm column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildUsers[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildUsers objects based on current ModelCriteria
 * @method     ChildUsers[]|ObjectCollection findById(int $id) Return ChildUsers objects filtered by the id column
 * @method     ChildUsers[]|ObjectCollection findByUsername(string $username) Return ChildUsers objects filtered by the username column
 * @method     ChildUsers[]|ObjectCollection findByNome(string $nome) Return ChildUsers objects filtered by the nome column
 * @method     ChildUsers[]|ObjectCollection findByCognome(string $cognome) Return ChildUsers objects filtered by the cognome column
 * @method     ChildUsers[]|ObjectCollection findByPassword(string $password) Return ChildUsers objects filtered by the password column
 * @method     ChildUsers[]|ObjectCollection findByAbitazione(string $abitazione) Return ChildUsers objects filtered by the abitazione column
 * @method     ChildUsers[]|ObjectCollection findByAutonomia(boolean $autonomia) Return ChildUsers objects filtered by the autonomia column
 * @method     ChildUsers[]|ObjectCollection findByEmail(string $email) Return ChildUsers objects filtered by the email column
 * @method     ChildUsers[]|ObjectCollection findByIdPlayerNotifiche(string $id_player_notifiche) Return ChildUsers objects filtered by the id_player_notifiche column
 * @method     ChildUsers[]|ObjectCollection findByInsertDate(string $insert_date) Return ChildUsers objects filtered by the insert_date column
 * @method     ChildUsers[]|ObjectCollection findByEmailConfirm(boolean $email_confirm) Return ChildUsers objects filtered by the email_confirm column
 * @method     ChildUsers[]|ObjectCollection findByFirstAccess(boolean $first_access) Return ChildUsers objects filtered by the first_access column
 * @method     ChildUsers[]|ObjectCollection findByCodeConfirm(string $code_confirm) Return ChildUsers objects filtered by the code_confirm column
 * @method     ChildUsers[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class UsersQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Montanari\Propel\Base\UsersQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Montanari\\Propel\\Users', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildUsersQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildUsersQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildUsersQuery) {
            return $criteria;
        }
        $query = new ChildUsersQuery();
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
     * @return ChildUsers|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = UsersTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildUsers A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, username, nome, cognome, password, abitazione, autonomia, email, id_player_notifiche, insert_date, email_confirm, first_access, code_confirm FROM users WHERE id = :p0';
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
            /** @var ChildUsers $obj */
            $obj = new ChildUsers();
            $obj->hydrate($row);
            UsersTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildUsers|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(UsersTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(UsersTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(UsersTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(UsersTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the username column
     *
     * Example usage:
     * <code>
     * $query->filterByUsername('fooValue');   // WHERE username = 'fooValue'
     * $query->filterByUsername('%fooValue%', Criteria::LIKE); // WHERE username LIKE '%fooValue%'
     * </code>
     *
     * @param     string $username The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByUsername($username = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($username)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_USERNAME, $username, $comparison);
    }

    /**
     * Filter the query on the nome column
     *
     * Example usage:
     * <code>
     * $query->filterByNome('fooValue');   // WHERE nome = 'fooValue'
     * $query->filterByNome('%fooValue%', Criteria::LIKE); // WHERE nome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nome The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query on the cognome column
     *
     * Example usage:
     * <code>
     * $query->filterByCognome('fooValue');   // WHERE cognome = 'fooValue'
     * $query->filterByCognome('%fooValue%', Criteria::LIKE); // WHERE cognome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $cognome The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByCognome($cognome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($cognome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_COGNOME, $cognome, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%', Criteria::LIKE); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the abitazione column
     *
     * Example usage:
     * <code>
     * $query->filterByAbitazione('fooValue');   // WHERE abitazione = 'fooValue'
     * $query->filterByAbitazione('%fooValue%', Criteria::LIKE); // WHERE abitazione LIKE '%fooValue%'
     * </code>
     *
     * @param     string $abitazione The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByAbitazione($abitazione = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($abitazione)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_ABITAZIONE, $abitazione, $comparison);
    }

    /**
     * Filter the query on the autonomia column
     *
     * Example usage:
     * <code>
     * $query->filterByAutonomia(true); // WHERE autonomia = true
     * $query->filterByAutonomia('yes'); // WHERE autonomia = true
     * </code>
     *
     * @param     boolean|string $autonomia The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByAutonomia($autonomia = null, $comparison = null)
    {
        if (is_string($autonomia)) {
            $autonomia = in_array(strtolower($autonomia), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UsersTableMap::COL_AUTONOMIA, $autonomia, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%', Criteria::LIKE); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the id_player_notifiche column
     *
     * Example usage:
     * <code>
     * $query->filterByIdPlayerNotifiche('fooValue');   // WHERE id_player_notifiche = 'fooValue'
     * $query->filterByIdPlayerNotifiche('%fooValue%', Criteria::LIKE); // WHERE id_player_notifiche LIKE '%fooValue%'
     * </code>
     *
     * @param     string $idPlayerNotifiche The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByIdPlayerNotifiche($idPlayerNotifiche = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($idPlayerNotifiche)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_ID_PLAYER_NOTIFICHE, $idPlayerNotifiche, $comparison);
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
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByInsertDate($insertDate = null, $comparison = null)
    {
        if (is_array($insertDate)) {
            $useMinMax = false;
            if (isset($insertDate['min'])) {
                $this->addUsingAlias(UsersTableMap::COL_INSERT_DATE, $insertDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($insertDate['max'])) {
                $this->addUsingAlias(UsersTableMap::COL_INSERT_DATE, $insertDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_INSERT_DATE, $insertDate, $comparison);
    }

    /**
     * Filter the query on the email_confirm column
     *
     * Example usage:
     * <code>
     * $query->filterByEmailConfirm(true); // WHERE email_confirm = true
     * $query->filterByEmailConfirm('yes'); // WHERE email_confirm = true
     * </code>
     *
     * @param     boolean|string $emailConfirm The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByEmailConfirm($emailConfirm = null, $comparison = null)
    {
        if (is_string($emailConfirm)) {
            $emailConfirm = in_array(strtolower($emailConfirm), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UsersTableMap::COL_EMAIL_CONFIRM, $emailConfirm, $comparison);
    }

    /**
     * Filter the query on the first_access column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstAccess(true); // WHERE first_access = true
     * $query->filterByFirstAccess('yes'); // WHERE first_access = true
     * </code>
     *
     * @param     boolean|string $firstAccess The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByFirstAccess($firstAccess = null, $comparison = null)
    {
        if (is_string($firstAccess)) {
            $firstAccess = in_array(strtolower($firstAccess), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(UsersTableMap::COL_FIRST_ACCESS, $firstAccess, $comparison);
    }

    /**
     * Filter the query on the code_confirm column
     *
     * Example usage:
     * <code>
     * $query->filterByCodeConfirm('fooValue');   // WHERE code_confirm = 'fooValue'
     * $query->filterByCodeConfirm('%fooValue%', Criteria::LIKE); // WHERE code_confirm LIKE '%fooValue%'
     * </code>
     *
     * @param     string $codeConfirm The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function filterByCodeConfirm($codeConfirm = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($codeConfirm)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(UsersTableMap::COL_CODE_CONFIRM, $codeConfirm, $comparison);
    }

    /**
     * Filter the query by a related \Montanari\Propel\Drivers object
     *
     * @param \Montanari\Propel\Drivers|ObjectCollection $drivers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByDrivers($drivers, $comparison = null)
    {
        if ($drivers instanceof \Montanari\Propel\Drivers) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_ID, $drivers->getIdUser(), $comparison);
        } elseif ($drivers instanceof ObjectCollection) {
            return $this
                ->useDriversQuery()
                ->filterByPrimaryKeys($drivers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDrivers() only accepts arguments of type \Montanari\Propel\Drivers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Drivers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinDrivers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Drivers');

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
            $this->addJoinObject($join, 'Drivers');
        }

        return $this;
    }

    /**
     * Use the Drivers relation Drivers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\DriversQuery A secondary query class using the current class as primary query
     */
    public function useDriversQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDrivers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Drivers', '\Montanari\Propel\DriversQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Messages object
     *
     * @param \Montanari\Propel\Messages|ObjectCollection $messages the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByMessagesRelatedByIdUserFrom($messages, $comparison = null)
    {
        if ($messages instanceof \Montanari\Propel\Messages) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_ID, $messages->getIdUserFrom(), $comparison);
        } elseif ($messages instanceof ObjectCollection) {
            return $this
                ->useMessagesRelatedByIdUserFromQuery()
                ->filterByPrimaryKeys($messages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessagesRelatedByIdUserFrom() only accepts arguments of type \Montanari\Propel\Messages or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MessagesRelatedByIdUserFrom relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinMessagesRelatedByIdUserFrom($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MessagesRelatedByIdUserFrom');

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
            $this->addJoinObject($join, 'MessagesRelatedByIdUserFrom');
        }

        return $this;
    }

    /**
     * Use the MessagesRelatedByIdUserFrom relation Messages object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\MessagesQuery A secondary query class using the current class as primary query
     */
    public function useMessagesRelatedByIdUserFromQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMessagesRelatedByIdUserFrom($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MessagesRelatedByIdUserFrom', '\Montanari\Propel\MessagesQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Messages object
     *
     * @param \Montanari\Propel\Messages|ObjectCollection $messages the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByMessagesRelatedByIdUserTo($messages, $comparison = null)
    {
        if ($messages instanceof \Montanari\Propel\Messages) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_ID, $messages->getIdUserTo(), $comparison);
        } elseif ($messages instanceof ObjectCollection) {
            return $this
                ->useMessagesRelatedByIdUserToQuery()
                ->filterByPrimaryKeys($messages->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMessagesRelatedByIdUserTo() only accepts arguments of type \Montanari\Propel\Messages or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the MessagesRelatedByIdUserTo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinMessagesRelatedByIdUserTo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('MessagesRelatedByIdUserTo');

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
            $this->addJoinObject($join, 'MessagesRelatedByIdUserTo');
        }

        return $this;
    }

    /**
     * Use the MessagesRelatedByIdUserTo relation Messages object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\MessagesQuery A secondary query class using the current class as primary query
     */
    public function useMessagesRelatedByIdUserToQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMessagesRelatedByIdUserTo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'MessagesRelatedByIdUserTo', '\Montanari\Propel\MessagesQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\Passengers object
     *
     * @param \Montanari\Propel\Passengers|ObjectCollection $passengers the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByPassengers($passengers, $comparison = null)
    {
        if ($passengers instanceof \Montanari\Propel\Passengers) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_ID, $passengers->getIdUser(), $comparison);
        } elseif ($passengers instanceof ObjectCollection) {
            return $this
                ->usePassengersQuery()
                ->filterByPrimaryKeys($passengers->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPassengers() only accepts arguments of type \Montanari\Propel\Passengers or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Passengers relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinPassengers($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Passengers');

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
            $this->addJoinObject($join, 'Passengers');
        }

        return $this;
    }

    /**
     * Use the Passengers relation Passengers object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\PassengersQuery A secondary query class using the current class as primary query
     */
    public function usePassengersQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPassengers($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Passengers', '\Montanari\Propel\PassengersQuery');
    }

    /**
     * Filter the query by a related \Montanari\Propel\UserSettings object
     *
     * @param \Montanari\Propel\UserSettings|ObjectCollection $userSettings the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildUsersQuery The current query, for fluid interface
     */
    public function filterByUserSettings($userSettings, $comparison = null)
    {
        if ($userSettings instanceof \Montanari\Propel\UserSettings) {
            return $this
                ->addUsingAlias(UsersTableMap::COL_ID, $userSettings->getIdUser(), $comparison);
        } elseif ($userSettings instanceof ObjectCollection) {
            return $this
                ->useUserSettingsQuery()
                ->filterByPrimaryKeys($userSettings->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByUserSettings() only accepts arguments of type \Montanari\Propel\UserSettings or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the UserSettings relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function joinUserSettings($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('UserSettings');

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
            $this->addJoinObject($join, 'UserSettings');
        }

        return $this;
    }

    /**
     * Use the UserSettings relation UserSettings object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \Montanari\Propel\UserSettingsQuery A secondary query class using the current class as primary query
     */
    public function useUserSettingsQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinUserSettings($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'UserSettings', '\Montanari\Propel\UserSettingsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildUsers $users Object to remove from the list of results
     *
     * @return $this|ChildUsersQuery The current query, for fluid interface
     */
    public function prune($users = null)
    {
        if ($users) {
            $this->addUsingAlias(UsersTableMap::COL_ID, $users->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the users table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            UsersTableMap::clearInstancePool();
            UsersTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(UsersTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            UsersTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            UsersTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // UsersQuery
