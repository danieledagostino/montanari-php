<?php

namespace Montanari\Propel\Map;

use Montanari\Propel\Events;
use Montanari\Propel\EventsQuery;
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
 * This class defines the structure of the 'events' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class EventsTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Montanari.Propel.Map.EventsTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'events';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Montanari\\Propel\\Events';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Montanari.Propel.Events';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 10;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 10;

    /**
     * the column name for the id field
     */
    const COL_ID = 'events.id';

    /**
     * the column name for the description field
     */
    const COL_DESCRIPTION = 'events.description';

    /**
     * the column name for the meeting_point field
     */
    const COL_MEETING_POINT = 'events.meeting_point';

    /**
     * the column name for the departure_coords field
     */
    const COL_DEPARTURE_COORDS = 'events.departure_coords';

    /**
     * the column name for the event_date field
     */
    const COL_EVENT_DATE = 'events.event_date';

    /**
     * the column name for the insert_date field
     */
    const COL_INSERT_DATE = 'events.insert_date';

    /**
     * the column name for the name field
     */
    const COL_NAME = 'events.name';

    /**
     * the column name for the meeting_point_name field
     */
    const COL_MEETING_POINT_NAME = 'events.meeting_point_name';

    /**
     * the column name for the id_fb field
     */
    const COL_ID_FB = 'events.id_fb';

    /**
     * the column name for the update_date field
     */
    const COL_UPDATE_DATE = 'events.update_date';

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
        self::TYPE_PHPNAME       => array('Id', 'Description', 'MeetingPoint', 'DepartureCoords', 'EventDate', 'InsertDate', 'Name', 'MeetingPointName', 'IdFb', 'UpdateDate', ),
        self::TYPE_CAMELNAME     => array('id', 'description', 'meetingPoint', 'departureCoords', 'eventDate', 'insertDate', 'name', 'meetingPointName', 'idFb', 'updateDate', ),
        self::TYPE_COLNAME       => array(EventsTableMap::COL_ID, EventsTableMap::COL_DESCRIPTION, EventsTableMap::COL_MEETING_POINT, EventsTableMap::COL_DEPARTURE_COORDS, EventsTableMap::COL_EVENT_DATE, EventsTableMap::COL_INSERT_DATE, EventsTableMap::COL_NAME, EventsTableMap::COL_MEETING_POINT_NAME, EventsTableMap::COL_ID_FB, EventsTableMap::COL_UPDATE_DATE, ),
        self::TYPE_FIELDNAME     => array('id', 'description', 'meeting_point', 'departure_coords', 'event_date', 'insert_date', 'name', 'meeting_point_name', 'id_fb', 'update_date', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Description' => 1, 'MeetingPoint' => 2, 'DepartureCoords' => 3, 'EventDate' => 4, 'InsertDate' => 5, 'Name' => 6, 'MeetingPointName' => 7, 'IdFb' => 8, 'UpdateDate' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'description' => 1, 'meetingPoint' => 2, 'departureCoords' => 3, 'eventDate' => 4, 'insertDate' => 5, 'name' => 6, 'meetingPointName' => 7, 'idFb' => 8, 'updateDate' => 9, ),
        self::TYPE_COLNAME       => array(EventsTableMap::COL_ID => 0, EventsTableMap::COL_DESCRIPTION => 1, EventsTableMap::COL_MEETING_POINT => 2, EventsTableMap::COL_DEPARTURE_COORDS => 3, EventsTableMap::COL_EVENT_DATE => 4, EventsTableMap::COL_INSERT_DATE => 5, EventsTableMap::COL_NAME => 6, EventsTableMap::COL_MEETING_POINT_NAME => 7, EventsTableMap::COL_ID_FB => 8, EventsTableMap::COL_UPDATE_DATE => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'description' => 1, 'meeting_point' => 2, 'departure_coords' => 3, 'event_date' => 4, 'insert_date' => 5, 'name' => 6, 'meeting_point_name' => 7, 'id_fb' => 8, 'update_date' => 9, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
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
        $this->setName('events');
        $this->setPhpName('Events');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\Montanari\\Propel\\Events');
        $this->setPackage('Montanari.Propel');
        $this->setUseIdGenerator(false);
        // columns
        $this->addPrimaryKey('id', 'Id', 'VARCHAR', true, 100, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', true, null, null);
        $this->addColumn('meeting_point', 'MeetingPoint', 'VARCHAR', true, 50, 'da definire');
        $this->addColumn('departure_coords', 'DepartureCoords', 'VARCHAR', false, 50, null);
        $this->addColumn('event_date', 'EventDate', 'DATE', false, null, null);
        $this->addColumn('insert_date', 'InsertDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('name', 'Name', 'VARCHAR', true, 100, null);
        $this->addColumn('meeting_point_name', 'MeetingPointName', 'VARCHAR', false, 50, null);
        $this->addColumn('id_fb', 'IdFb', 'VARCHAR', true, 100, null);
        $this->addColumn('update_date', 'UpdateDate', 'TIMESTAMP', true, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CarOrganization', '\\Montanari\\Propel\\CarOrganization', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_event',
    1 => ':id',
  ),
), null, null, 'CarOrganizations', false);
        $this->addRelation('Drivers', '\\Montanari\\Propel\\Drivers', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_event',
    1 => ':id',
  ),
), null, null, 'Driverss', false);
        $this->addRelation('Passengers', '\\Montanari\\Propel\\Passengers', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':id_event',
    1 => ':id',
  ),
), null, null, 'Passengerss', false);
    } // buildRelations()

    /**
     *
     * Gets the list of behaviors registered for this table
     *
     * @return array Associative array (name => parameters) of behaviors
     */
    public function getBehaviors()
    {
        return array(
            'timestampable' => array('create_column' => 'created_at', 'update_column' => 'update_date', 'disable_created_at' => 'true', 'disable_updated_at' => 'false', ),
        );
    } // getBehaviors()

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
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return null === $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] || is_scalar($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)]) || is_callable([$row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)], '__toString']) ? (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] : $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
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
        return (string) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
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
        return $withPrefix ? EventsTableMap::CLASS_DEFAULT : EventsTableMap::OM_CLASS;
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
     * @return array           (Events object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = EventsTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = EventsTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + EventsTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = EventsTableMap::OM_CLASS;
            /** @var Events $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            EventsTableMap::addInstanceToPool($obj, $key);
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
            $key = EventsTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = EventsTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Events $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                EventsTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(EventsTableMap::COL_ID);
            $criteria->addSelectColumn(EventsTableMap::COL_DESCRIPTION);
            $criteria->addSelectColumn(EventsTableMap::COL_MEETING_POINT);
            $criteria->addSelectColumn(EventsTableMap::COL_DEPARTURE_COORDS);
            $criteria->addSelectColumn(EventsTableMap::COL_EVENT_DATE);
            $criteria->addSelectColumn(EventsTableMap::COL_INSERT_DATE);
            $criteria->addSelectColumn(EventsTableMap::COL_NAME);
            $criteria->addSelectColumn(EventsTableMap::COL_MEETING_POINT_NAME);
            $criteria->addSelectColumn(EventsTableMap::COL_ID_FB);
            $criteria->addSelectColumn(EventsTableMap::COL_UPDATE_DATE);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.meeting_point');
            $criteria->addSelectColumn($alias . '.departure_coords');
            $criteria->addSelectColumn($alias . '.event_date');
            $criteria->addSelectColumn($alias . '.insert_date');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.meeting_point_name');
            $criteria->addSelectColumn($alias . '.id_fb');
            $criteria->addSelectColumn($alias . '.update_date');
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
        return Propel::getServiceContainer()->getDatabaseMap(EventsTableMap::DATABASE_NAME)->getTable(EventsTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(EventsTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(EventsTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new EventsTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Events or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Events object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Montanari\Propel\Events) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(EventsTableMap::DATABASE_NAME);
            $criteria->add(EventsTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = EventsQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            EventsTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                EventsTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the events table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return EventsQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Events or Criteria object.
     *
     * @param mixed               $criteria Criteria or Events object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Events object
        }


        // Set the correct dbName
        $query = EventsQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // EventsTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
EventsTableMap::buildTableMap();
