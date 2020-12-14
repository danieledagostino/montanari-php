<?php

namespace Montanari\Propel\Map;

use Montanari\Propel\Messages;
use Montanari\Propel\MessagesQuery;
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
 * This class defines the structure of the 'messages' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class MessagesTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'Montanari.Propel.Map.MessagesTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'default';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'messages';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\Montanari\\Propel\\Messages';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'Montanari.Propel.Messages';

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
    const COL_ID = 'messages.id';

    /**
     * the column name for the id_user_from field
     */
    const COL_ID_USER_FROM = 'messages.id_user_from';

    /**
     * the column name for the id_user_to field
     */
    const COL_ID_USER_TO = 'messages.id_user_to';

    /**
     * the column name for the message field
     */
    const COL_MESSAGE = 'messages.message';

    /**
     * the column name for the read field
     */
    const COL_READ = 'messages.read';

    /**
     * the column name for the delete field
     */
    const COL_DELETE = 'messages.delete';

    /**
     * the column name for the insert_date field
     */
    const COL_INSERT_DATE = 'messages.insert_date';

    /**
     * the column name for the type field
     */
    const COL_TYPE = 'messages.type';

    /**
     * the column name for the subject field
     */
    const COL_SUBJECT = 'messages.subject';

    /**
     * the column name for the parent field
     */
    const COL_PARENT = 'messages.parent';

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
        self::TYPE_PHPNAME       => array('Id', 'IdUserFrom', 'IdUserTo', 'Message', 'Read', 'Delete', 'InsertDate', 'Type', 'Subject', 'Parent', ),
        self::TYPE_CAMELNAME     => array('id', 'idUserFrom', 'idUserTo', 'message', 'read', 'delete', 'insertDate', 'type', 'subject', 'parent', ),
        self::TYPE_COLNAME       => array(MessagesTableMap::COL_ID, MessagesTableMap::COL_ID_USER_FROM, MessagesTableMap::COL_ID_USER_TO, MessagesTableMap::COL_MESSAGE, MessagesTableMap::COL_READ, MessagesTableMap::COL_DELETE, MessagesTableMap::COL_INSERT_DATE, MessagesTableMap::COL_TYPE, MessagesTableMap::COL_SUBJECT, MessagesTableMap::COL_PARENT, ),
        self::TYPE_FIELDNAME     => array('id', 'id_user_from', 'id_user_to', 'message', 'read', 'delete', 'insert_date', 'type', 'subject', 'parent', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'IdUserFrom' => 1, 'IdUserTo' => 2, 'Message' => 3, 'Read' => 4, 'Delete' => 5, 'InsertDate' => 6, 'Type' => 7, 'Subject' => 8, 'Parent' => 9, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'idUserFrom' => 1, 'idUserTo' => 2, 'message' => 3, 'read' => 4, 'delete' => 5, 'insertDate' => 6, 'type' => 7, 'subject' => 8, 'parent' => 9, ),
        self::TYPE_COLNAME       => array(MessagesTableMap::COL_ID => 0, MessagesTableMap::COL_ID_USER_FROM => 1, MessagesTableMap::COL_ID_USER_TO => 2, MessagesTableMap::COL_MESSAGE => 3, MessagesTableMap::COL_READ => 4, MessagesTableMap::COL_DELETE => 5, MessagesTableMap::COL_INSERT_DATE => 6, MessagesTableMap::COL_TYPE => 7, MessagesTableMap::COL_SUBJECT => 8, MessagesTableMap::COL_PARENT => 9, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'id_user_from' => 1, 'id_user_to' => 2, 'message' => 3, 'read' => 4, 'delete' => 5, 'insert_date' => 6, 'type' => 7, 'subject' => 8, 'parent' => 9, ),
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
        $this->setName('messages');
        $this->setPhpName('Messages');
        $this->setIdentifierQuoting(true);
        $this->setClassName('\\Montanari\\Propel\\Messages');
        $this->setPackage('Montanari.Propel');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'BIGINT', true, null, null);
        $this->addForeignKey('id_user_from', 'IdUserFrom', 'INTEGER', 'users', 'id', true, null, null);
        $this->addForeignKey('id_user_to', 'IdUserTo', 'INTEGER', 'users', 'id', true, null, null);
        $this->addColumn('message', 'Message', 'LONGVARCHAR', true, null, null);
        $this->addColumn('read', 'Read', 'BOOLEAN', true, 1, false);
        $this->addColumn('delete', 'Delete', 'BOOLEAN', true, 1, false);
        $this->addColumn('insert_date', 'InsertDate', 'TIMESTAMP', true, null, 'CURRENT_TIMESTAMP');
        $this->addColumn('type', 'Type', 'VARCHAR', false, 15, null);
        $this->addColumn('subject', 'Subject', 'VARCHAR', false, 100, null);
        $this->addForeignKey('parent', 'Parent', 'BIGINT', 'messages', 'id', false, null, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('UserFrom', '\\Montanari\\Propel\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_user_from',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('UserTo', '\\Montanari\\Propel\\Users', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':id_user_to',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('ParentTo', '\\Montanari\\Propel\\Messages', RelationMap::MANY_TO_ONE, array (
  0 =>
  array (
    0 => ':parent',
    1 => ':id',
  ),
), null, null, null, false);
        $this->addRelation('MessagesRelatedById', '\\Montanari\\Propel\\Messages', RelationMap::ONE_TO_MANY, array (
  0 =>
  array (
    0 => ':parent',
    1 => ':id',
  ),
), null, null, 'MessagessRelatedById', false);
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
        return $withPrefix ? MessagesTableMap::CLASS_DEFAULT : MessagesTableMap::OM_CLASS;
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
     * @return array           (Messages object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = MessagesTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = MessagesTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + MessagesTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = MessagesTableMap::OM_CLASS;
            /** @var Messages $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            MessagesTableMap::addInstanceToPool($obj, $key);
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
            $key = MessagesTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = MessagesTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var Messages $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                MessagesTableMap::addInstanceToPool($obj, $key);
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
            $criteria->addSelectColumn(MessagesTableMap::COL_ID);
            $criteria->addSelectColumn(MessagesTableMap::COL_ID_USER_FROM);
            $criteria->addSelectColumn(MessagesTableMap::COL_ID_USER_TO);
            $criteria->addSelectColumn(MessagesTableMap::COL_MESSAGE);
            $criteria->addSelectColumn(MessagesTableMap::COL_READ);
            $criteria->addSelectColumn(MessagesTableMap::COL_DELETE);
            $criteria->addSelectColumn(MessagesTableMap::COL_INSERT_DATE);
            $criteria->addSelectColumn(MessagesTableMap::COL_TYPE);
            $criteria->addSelectColumn(MessagesTableMap::COL_SUBJECT);
            $criteria->addSelectColumn(MessagesTableMap::COL_PARENT);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.id_user_from');
            $criteria->addSelectColumn($alias . '.id_user_to');
            $criteria->addSelectColumn($alias . '.message');
            $criteria->addSelectColumn($alias . '.read');
            $criteria->addSelectColumn($alias . '.delete');
            $criteria->addSelectColumn($alias . '.insert_date');
            $criteria->addSelectColumn($alias . '.type');
            $criteria->addSelectColumn($alias . '.subject');
            $criteria->addSelectColumn($alias . '.parent');
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
        return Propel::getServiceContainer()->getDatabaseMap(MessagesTableMap::DATABASE_NAME)->getTable(MessagesTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(MessagesTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(MessagesTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new MessagesTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a Messages or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or Messages object or primary key or array of primary keys
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
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \Montanari\Propel\Messages) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(MessagesTableMap::DATABASE_NAME);
            $criteria->add(MessagesTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = MessagesQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            MessagesTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                MessagesTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the messages table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return MessagesQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a Messages or Criteria object.
     *
     * @param mixed               $criteria Criteria or Messages object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from Messages object
        }

        if ($criteria->containsKey(MessagesTableMap::COL_ID) && $criteria->keyContainsValue(MessagesTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.MessagesTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = MessagesQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // MessagesTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
MessagesTableMap::buildTableMap();
