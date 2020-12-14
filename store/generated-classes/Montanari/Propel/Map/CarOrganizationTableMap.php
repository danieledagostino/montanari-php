<?php

namespace Montanari\Propel\Map;

use Montanari\Propel\CarOrganization;
use Montanari\Propel\CarOrganizationQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'car_organization' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class CarOrganizationTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Montanari.Propel.Map.CarOrganizationTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'car_organization';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Montanari\\Propel\\CarOrganization';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Montanari.Propel.CarOrganization';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 6;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 6;

    /**
     * the column name for the id_driver field
     */
    const COL_ID_DRIVER = 'car_organization.id_driver';

    /**
     * the column name for the id_passenger field
     */
    const COL_ID_PASSENGER = 'car_organization.id_passenger';

    /**
     * the column name for the id_event field
     */
    const COL_ID_EVENT = 'car_organization.id_event';

    /**
     * the column name for the confirmed field
     */
    const COL_CONFIRMED = 'car_organization.confirmed';

    /**
     * the column name for the confirm_code field
     */
    const COL_CONFIRM_CODE = 'car_organization.confirm_code';

    /**
     * the column name for the insert_date field
     */
    const COL_INSERT_DATE = 'car_organization.insert_date';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('IdDriver', 'IdPassenger', 'IdEvent', 'Confirmed', 'ConfirmCode', 'InsertDate', ),
        self::TYPE_CAMELNAME     => array('idDriver', 'idPassenger', 'idEvent', 'confirmed', 'confirmCode', 'insertDate', ),
        self::TYPE_COLNAME       => array(CarOrganizationTableMap::COL_ID_DRIVER, CarOrganizationTableMap::COL_ID_PASSENGER, CarOrganizationTableMap::COL_ID_EVENT, CarOrganizationTableMap::COL_CONFIRMED, CarOrganizationTableMap::COL_CONFIRM_CODE, CarOrganizationTableMap::COL_INSERT_DATE, ),
        self::TYPE_FIELDNAME     => array('id_driver', 'id_passenger', 'id_event', 'confirmed', 'confirm_code', 'insert_date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdDriver' => 0, 'IdPassenger' => 1, 'IdEvent' => 2, 'Confirmed' => 3, 'ConfirmCode' => 4, 'InsertDate' => 5, ),
        self::TYPE_CAMELNAME     => array('idDriver' => 0, 'idPassenger' => 1, 'idEvent' => 2, 'confirmed' => 3, 'confirmCode' => 4, 'insertDate' => 5, ),
        self::TYPE_COLNAME       => array(CarOrganizationTableMap::COL_ID_DRIVER => 0, CarOrganizationTableMap::COL_ID_PASSENGER => 1, CarOrganizationTableMap::COL_ID_EVENT => 2, CarOrganizationTableMap::COL_CONFIRMED => 3, CarOrganizationTableMap::COL_CONFIRM_CODE => 4, CarOrganizationTableMap::COL_INSERT_DATE => 5, ),
        self::TYPE_FIELDNAME     => array('id_driver' => 0, 'id_passenger' => 1, 'id_event' => 2, 'confirmed' => 3, 'confirm_code' => 4, 'insert_date' => 5, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('car_organization');
        $this->setPhpName('CarOrganization');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Montanari\\Propel\\CarOrganization');
        $this->setPackage('Montanari.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addForeignPrimaryKey('id_driver', 'IdDriver', 'INTEGER' , 'drivers', 'id', true, 4, null);
        $this->addForeignPrimaryKey('id_passenger', 'IdPassenger', 'INTEGER' , 'passengers', 'id', true, 4, null);
        $this->addForeignPrimaryKey('id_event', 'IdEvent', 'VARCHAR' , 'events', 'id', true, 100, null);
        $this->addColumn('confirmed', 'Confirmed', 'INTEGER', true, 1, 0);
        $this->addColumn('confirm_code', 'ConfirmCode', 'VARCHAR', false, 16, null);
        $this->addColumn('insert_date', 'InsertDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Driver', '\\Montanari\\Propel\\Drivers', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_driver',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Passenger', '\\Montanari\\Propel\\Passengers', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_passenger',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('Events', '\\Montanari\\Propel\\Events', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_event',
    1 => ':id',
  ),
), null, null, null, false);
    } // buildRelations()

    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database. In some cases you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by find*()
     * and findPk*() calls.
     *
     * @param \Montanari\Propel\CarOrganization $obj A \Montanari\Propel\CarOrganization object.
     * @param string $key             (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (null === $key) {
                $key = serialize([(null === $obj->getIdDriver() || is_scalar($obj->getIdDriver()) || is_callable([$obj->getIdDriver(), '__toString']) ? (string) $obj->getIdDriver() : $obj->getIdDriver()), (null === $obj->getIdPassenger() || is_scalar($obj->getIdPassenger()) || is_callable([$obj->getIdPassenger(), '__toString']) ? (string) $obj->getIdPassenger() : $obj->getIdPassenger()), (null === $obj->getIdEvent() || is_scalar($obj->getIdEvent()) || is_callable([$obj->getIdEvent(), '__toString']) ? (string) $obj->getIdEvent() : $obj->getIdEvent())]);
            } // if key === null
            self::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param mixed $value A \Montanari\Propel\CarOrganization object or a primary key value.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && null !== $value) {
            if (is_object($value) && $value instanceof \Montanari\Propel\CarOrganization) {
                $key = serialize([(null === $value->getIdDriver() || is_scalar($value->getIdDriver()) || is_callable([$value->getIdDriver(), '__toString']) ? (string) $value->getIdDriver() : $value->getIdDriver()), (null === $value->getIdPassenger() || is_scalar($value->getIdPassenger()) || is_callable([$value->getIdPassenger(), '__toString']) ? (string) $value->getIdPassenger() : $value->getIdPassenger()), (null === $value->getIdEvent() || is_scalar($value->getIdEvent()) || is_callable([$value->getIdEvent(), '__toString']) ? (string) $value->getIdEvent() : $value->getIdEvent())]);

            } elseif (is_array($value) && count($value) === 3) {
                // assume we've been passed a primary key";
                $key = serialize([(null === $value[0] || is_scalar($value[0]) || is_callable([$value[0], '__toString']) ? (string) $value[0] : $value[0]), (null === $value[1] || is_scalar($value[1]) || is_callable([$value[1], '__toString']) ? (string) $value[1] : $value[1]), (null === $value[2] || is_scalar($value[2]) || is_callable([$value[2], '__toString']) ? (string) $value[2] : $value[2])]);
            } elseif ($value instanceof Criteria) {
                self::$instances = [];

                return;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or \Montanari\Propel\CarOrganization object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value, true)));
                throw $e;
            }

            unset(self::$instances[$key]);
        }
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)] === null && $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return serialize([(null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 1 + $offset : static::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)]), (null === $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 2 + $offset : static::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)])]);
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
            $pks = [];

        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdDriver', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 1 + $offset
                : self::translateFieldName('IdPassenger', TableMap::TYPE_PHPNAME, $indexType)
        ];
        $pks[] = (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 2 + $offset
                : self::translateFieldName('IdEvent', TableMap::TYPE_PHPNAME, $indexType)
        ];

        return $pks;
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? CarOrganizationTableMap::CLASS_DEFAULT : CarOrganizationTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (CarOrganization object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = CarOrganizationTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = CarOrganizationTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + CarOrganizationTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CarOrganizationTableMap::OM_CLASS;
            /** @var CarOrganization $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            CarOrganizationTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = CarOrganizationTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = CarOrganizationTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var CarOrganization $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CarOrganizationTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(CarOrganizationTableMap::COL_ID_DRIVER);
            $criteria->addSelectColumn(CarOrganizationTableMap::COL_ID_PASSENGER);
            $criteria->addSelectColumn(CarOrganizationTableMap::COL_ID_EVENT);
            $criteria->addSelectColumn(CarOrganizationTableMap::COL_CONFIRMED);
            $criteria->addSelectColumn(CarOrganizationTableMap::COL_CONFIRM_CODE);
            $criteria->addSelectColumn(CarOrganizationTableMap::COL_INSERT_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id_driver');
            $criteria->addSelectColumn($alias . '.id_passenger');
            $criteria->addSelectColumn($alias . '.id_event');
            $criteria->addSelectColumn($alias . '.confirmed');
            $criteria->addSelectColumn($alias . '.confirm_code');
            $criteria->addSelectColumn($alias . '.insert_date');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(CarOrganizationTableMap::DATABASE_NAME)->getTable(CarOrganizationTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(CarOrganizationTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(CarOrganizationTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new CarOrganizationTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a CarOrganization or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or CarOrganization object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarOrganizationTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Montanari\Propel\CarOrganization) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CarOrganizationTableMap::DATABASE_NAME);
            // primary key is composite; we therefore, expect
            // the primary key passed to be an array of pkey values
            if (count($values) == count($values, COUNT_RECURSIVE)) {
                // array is not multi-dimensional
                $values = array($values);
            }
            foreach ($values as $value) {
                $criterion = $criteria->getNewCriterion(CarOrganizationTableMap::COL_ID_DRIVER, $value[0]);
                $criterion->addAnd($criteria->getNewCriterion(CarOrganizationTableMap::COL_ID_PASSENGER, $value[1]));
                $criterion->addAnd($criteria->getNewCriterion(CarOrganizationTableMap::COL_ID_EVENT, $value[2]));
                $criteria->addOr($criterion);
            }
        }

        $query = CarOrganizationQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            CarOrganizationTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                CarOrganizationTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the car_organization table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return CarOrganizationQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a CarOrganization or Criteria object.
     *
     * @param mixed               $criteria Criteria or CarOrganization object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CarOrganizationTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from CarOrganization object
        }


        // Set the correct dbName
        $query = CarOrganizationQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // CarOrganizationTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
CarOrganizationTableMap::buildTableMap();
