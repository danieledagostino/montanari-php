<?php

namespace Montanari\Propel\Map;

use Montanari\Propel\Settings;
use Montanari\Propel\SettingsQuery;
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
 * This class defines the structure of the 'user_settings' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class SettingsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Montanari.Propel.Map.SettingsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'user_settings';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Montanari\\Propel\\Settings';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Montanari.Propel.Settings';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 5;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 5;

    /**
     * the column name for the id_user field
     */
    const COL_ID_USER = 'user_settings.id_user';

    /**
     * the column name for the push_message field
     */
    const COL_PUSH_MESSAGE = 'user_settings.push_message';

    /**
     * the column name for the email_message field
     */
    const COL_EMAIL_MESSAGE = 'user_settings.email_message';

    /**
     * the column name for the email_car_summary field
     */
    const COL_EMAIL_CAR_SUMMARY = 'user_settings.email_car_summary';

    /**
     * the column name for the email_event_summary field
     */
    const COL_EMAIL_EVENT_SUMMARY = 'user_settings.email_event_summary';

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
        self::TYPE_PHPNAME       => array('IdUser', 'PushMessage', 'EmailMessage', 'EmailCarSummary', 'EmailEventSummary', ),
        self::TYPE_CAMELNAME     => array('idUser', 'pushMessage', 'emailMessage', 'emailCarSummary', 'emailEventSummary', ),
        self::TYPE_COLNAME       => array(SettingsTableMap::COL_ID_USER, SettingsTableMap::COL_PUSH_MESSAGE, SettingsTableMap::COL_EMAIL_MESSAGE, SettingsTableMap::COL_EMAIL_CAR_SUMMARY, SettingsTableMap::COL_EMAIL_EVENT_SUMMARY, ),
        self::TYPE_FIELDNAME     => array('id_user', 'push_message', 'email_message', 'email_car_summary', 'email_event_summary', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('IdUser' => 0, 'PushMessage' => 1, 'EmailMessage' => 2, 'EmailCarSummary' => 3, 'EmailEventSummary' => 4, ),
        self::TYPE_CAMELNAME     => array('idUser' => 0, 'pushMessage' => 1, 'emailMessage' => 2, 'emailCarSummary' => 3, 'emailEventSummary' => 4, ),
        self::TYPE_COLNAME       => array(SettingsTableMap::COL_ID_USER => 0, SettingsTableMap::COL_PUSH_MESSAGE => 1, SettingsTableMap::COL_EMAIL_MESSAGE => 2, SettingsTableMap::COL_EMAIL_CAR_SUMMARY => 3, SettingsTableMap::COL_EMAIL_EVENT_SUMMARY => 4, ),
        self::TYPE_FIELDNAME     => array('id_user' => 0, 'push_message' => 1, 'email_message' => 2, 'email_car_summary' => 3, 'email_event_summary' => 4, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, )
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
        $this->setName('user_settings');
        $this->setPhpName('Settings');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Montanari\\Propel\\Settings');
        $this->setPackage('Montanari.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id_user', 'IdUser', 'INTEGER', true, 4, null);
        $this->addColumn('push_message', 'PushMessage', 'VARCHAR', true, 2, 'si');
        $this->addColumn('email_message', 'EmailMessage', 'VARCHAR', true, 2, 'si');
        $this->addColumn('email_car_summary', 'EmailCarSummary', 'VARCHAR', true, 2, 'si');
        $this->addColumn('email_event_summary', 'EmailEventSummary', 'VARCHAR', true, 2, 'si');
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
    } // buildRelations()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('IdUser', TableMap::TYPE_PHPNAME, $indexType)
        ];
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
        return $withPrefix ? SettingsTableMap::CLASS_DEFAULT : SettingsTableMap::OM_CLASS;
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
     * @return array           (Settings object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = SettingsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = SettingsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + SettingsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = SettingsTableMap::OM_CLASS;
            /** @var Settings $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            SettingsTableMap::addInstanceToPool($obj, $key);
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
            $key = SettingsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = SettingsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Settings $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                SettingsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(SettingsTableMap::COL_ID_USER);
            $criteria->addSelectColumn(SettingsTableMap::COL_PUSH_MESSAGE);
            $criteria->addSelectColumn(SettingsTableMap::COL_EMAIL_MESSAGE);
            $criteria->addSelectColumn(SettingsTableMap::COL_EMAIL_CAR_SUMMARY);
            $criteria->addSelectColumn(SettingsTableMap::COL_EMAIL_EVENT_SUMMARY);
        } else {
            $criteria->addSelectColumn($alias . '.id_user');
            $criteria->addSelectColumn($alias . '.push_message');
            $criteria->addSelectColumn($alias . '.email_message');
            $criteria->addSelectColumn($alias . '.email_car_summary');
            $criteria->addSelectColumn($alias . '.email_event_summary');
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
        return Propel::getServiceContainer()->getDatabaseMap(SettingsTableMap::DATABASE_NAME)->getTable(SettingsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(SettingsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(SettingsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new SettingsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Settings or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Settings object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(SettingsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Montanari\Propel\Settings) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(SettingsTableMap::DATABASE_NAME);
            $criteria->add(SettingsTableMap::COL_ID_USER, (array) $values, Criteria::IN);
        }

        $query = SettingsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            SettingsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                SettingsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the user_settings table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return SettingsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Settings or Criteria object.
     *
     * @param mixed               $criteria Criteria or Settings object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(SettingsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Settings object
        }


        // Set the correct dbName
        $query = SettingsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // SettingsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
SettingsTableMap::buildTableMap();
