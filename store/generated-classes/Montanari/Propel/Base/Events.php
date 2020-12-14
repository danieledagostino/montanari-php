<?php

namespace Montanari\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use Montanari\Propel\CarOrganization as ChildCarOrganization;
use Montanari\Propel\CarOrganizationQuery as ChildCarOrganizationQuery;
use Montanari\Propel\Drivers as ChildDrivers;
use Montanari\Propel\DriversQuery as ChildDriversQuery;
use Montanari\Propel\Events as ChildEvents;
use Montanari\Propel\EventsQuery as ChildEventsQuery;
use Montanari\Propel\Passengers as ChildPassengers;
use Montanari\Propel\PassengersQuery as ChildPassengersQuery;
use Montanari\Propel\Map\CarOrganizationTableMap;
use Montanari\Propel\Map\DriversTableMap;
use Montanari\Propel\Map\EventsTableMap;
use Montanari\Propel\Map\PassengersTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'events' table.
 *
 *
 *
 * @package    propel.generator.Montanari.Propel.Base
 */
abstract class Events implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Montanari\\Propel\\Map\\EventsTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        string
     */
    protected $id;

    /**
     * The value for the description field.
     *
     * @var        string
     */
    protected $description;

    /**
     * The value for the meeting_point field.
     *
     * Note: this column has a database default value of: 'da definire'
     * @var        string
     */
    protected $meeting_point;

    /**
     * The value for the departure_coords field.
     *
     * @var        string
     */
    protected $departure_coords;

    /**
     * The value for the event_date field.
     *
     * @var        DateTime
     */
    protected $event_date;

    /**
     * The value for the insert_date field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $insert_date;

    /**
     * The value for the name field.
     *
     * @var        string
     */
    protected $name;

    /**
     * The value for the meeting_point_name field.
     *
     * @var        string
     */
    protected $meeting_point_name;

    /**
     * The value for the id_fb field.
     *
     * @var        string
     */
    protected $id_fb;

    /**
     * The value for the update_date field.
     *
     * @var        DateTime
     */
    protected $update_date;

    /**
     * @var        ObjectCollection|ChildCarOrganization[] Collection to store aggregation of ChildCarOrganization objects.
     */
    protected $collCarOrganizations;
    protected $collCarOrganizationsPartial;

    /**
     * @var        ObjectCollection|ChildDrivers[] Collection to store aggregation of ChildDrivers objects.
     */
    protected $collDriverss;
    protected $collDriverssPartial;

    /**
     * @var        ObjectCollection|ChildPassengers[] Collection to store aggregation of ChildPassengers objects.
     */
    protected $collPassengerss;
    protected $collPassengerssPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildCarOrganization[]
     */
    protected $carOrganizationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDrivers[]
     */
    protected $driverssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPassengers[]
     */
    protected $passengerssScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->meeting_point = 'da definire';
    }

    /**
     * Initializes internal state of Montanari\Propel\Base\Events object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Events</code> instance.  If
     * <code>obj</code> is an instance of <code>Events</code>, delegates to
     * <code>equals(Events)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Events The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the [meeting_point] column value.
     *
     * @return string
     */
    public function getMeetingPoint()
    {
        return $this->meeting_point;
    }

    /**
     * Get the [departure_coords] column value.
     *
     * @return string
     */
    public function getDepartureCoords()
    {
        return $this->departure_coords;
    }

    /**
     * Get the [optionally formatted] temporal [event_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getEventDate($format = NULL)
    {
        if ($format === null) {
            return $this->event_date;
        } else {
            return $this->event_date instanceof \DateTimeInterface ? $this->event_date->format($format) : null;
        }
    }

    /**
     * Get the [optionally formatted] temporal [insert_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getInsertDate($format = NULL)
    {
        if ($format === null) {
            return $this->insert_date;
        } else {
            return $this->insert_date instanceof \DateTimeInterface ? $this->insert_date->format($format) : null;
        }
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [meeting_point_name] column value.
     *
     * @return string
     */
    public function getMeetingPointName()
    {
        return $this->meeting_point_name;
    }

    /**
     * Get the [id_fb] column value.
     *
     * @return string
     */
    public function getIdFb()
    {
        return $this->id_fb;
    }

    /**
     * Get the [optionally formatted] temporal [update_date] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getUpdateDate($format = NULL)
    {
        if ($format === null) {
            return $this->update_date;
        } else {
            return $this->update_date instanceof \DateTimeInterface ? $this->update_date->format($format) : null;
        }
    }

    /**
     * Set the value of [id] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[EventsTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[EventsTableMap::COL_DESCRIPTION] = true;
        }

        return $this;
    } // setDescription()

    /**
     * Set the value of [meeting_point] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setMeetingPoint($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meeting_point !== $v) {
            $this->meeting_point = $v;
            $this->modifiedColumns[EventsTableMap::COL_MEETING_POINT] = true;
        }

        return $this;
    } // setMeetingPoint()

    /**
     * Set the value of [departure_coords] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setDepartureCoords($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->departure_coords !== $v) {
            $this->departure_coords = $v;
            $this->modifiedColumns[EventsTableMap::COL_DEPARTURE_COORDS] = true;
        }

        return $this;
    } // setDepartureCoords()

    /**
     * Sets the value of [event_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setEventDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->event_date !== null || $dt !== null) {
            if ($this->event_date === null || $dt === null || $dt->format("Y-m-d") !== $this->event_date->format("Y-m-d")) {
                $this->event_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventsTableMap::COL_EVENT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setEventDate()

    /**
     * Sets the value of [insert_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setInsertDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->insert_date !== null || $dt !== null) {
            if ($this->insert_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->insert_date->format("Y-m-d H:i:s.u")) {
                $this->insert_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventsTableMap::COL_INSERT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInsertDate()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[EventsTableMap::COL_NAME] = true;
        }

        return $this;
    } // setName()

    /**
     * Set the value of [meeting_point_name] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setMeetingPointName($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->meeting_point_name !== $v) {
            $this->meeting_point_name = $v;
            $this->modifiedColumns[EventsTableMap::COL_MEETING_POINT_NAME] = true;
        }

        return $this;
    } // setMeetingPointName()

    /**
     * Set the value of [id_fb] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setIdFb($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_fb !== $v) {
            $this->id_fb = $v;
            $this->modifiedColumns[EventsTableMap::COL_ID_FB] = true;
        }

        return $this;
    } // setIdFb()

    /**
     * Sets the value of [update_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function setUpdateDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->update_date !== null || $dt !== null) {
            if ($this->update_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->update_date->format("Y-m-d H:i:s.u")) {
                $this->update_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[EventsTableMap::COL_UPDATE_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setUpdateDate()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->meeting_point !== 'da definire') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : EventsTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : EventsTableMap::translateFieldName('Description', TableMap::TYPE_PHPNAME, $indexType)];
            $this->description = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : EventsTableMap::translateFieldName('MeetingPoint', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meeting_point = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : EventsTableMap::translateFieldName('DepartureCoords', TableMap::TYPE_PHPNAME, $indexType)];
            $this->departure_coords = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : EventsTableMap::translateFieldName('EventDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00') {
                $col = null;
            }
            $this->event_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : EventsTableMap::translateFieldName('InsertDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->insert_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : EventsTableMap::translateFieldName('Name', TableMap::TYPE_PHPNAME, $indexType)];
            $this->name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : EventsTableMap::translateFieldName('MeetingPointName', TableMap::TYPE_PHPNAME, $indexType)];
            $this->meeting_point_name = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : EventsTableMap::translateFieldName('IdFb', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_fb = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : EventsTableMap::translateFieldName('UpdateDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->update_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = EventsTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Montanari\\Propel\\Events'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(EventsTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildEventsQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collCarOrganizations = null;

            $this->collDriverss = null;

            $this->collPassengerss = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Events::setDeleted()
     * @see Events::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildEventsQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(EventsTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
                // timestampable behavior
                $time = time();
                $highPrecision = \Propel\Runtime\Util\PropelDateTime::createHighPrecision();
                if (!$this->isColumnModified(EventsTableMap::COL_UPDATE_DATE)) {
                    $this->setUpdateDate($highPrecision);
                }
            } else {
                $ret = $ret && $this->preUpdate($con);
                // timestampable behavior
                if ($this->isModified() && !$this->isColumnModified(EventsTableMap::COL_UPDATE_DATE)) {
                    $this->setUpdateDate(\Propel\Runtime\Util\PropelDateTime::createHighPrecision());
                }
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                EventsTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->carOrganizationsScheduledForDeletion !== null) {
                if (!$this->carOrganizationsScheduledForDeletion->isEmpty()) {
                    \Montanari\Propel\CarOrganizationQuery::create()
                        ->filterByPrimaryKeys($this->carOrganizationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->carOrganizationsScheduledForDeletion = null;
                }
            }

            if ($this->collCarOrganizations !== null) {
                foreach ($this->collCarOrganizations as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->driverssScheduledForDeletion !== null) {
                if (!$this->driverssScheduledForDeletion->isEmpty()) {
                    \Montanari\Propel\DriversQuery::create()
                        ->filterByPrimaryKeys($this->driverssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->driverssScheduledForDeletion = null;
                }
            }

            if ($this->collDriverss !== null) {
                foreach ($this->collDriverss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->passengerssScheduledForDeletion !== null) {
                if (!$this->passengerssScheduledForDeletion->isEmpty()) {
                    \Montanari\Propel\PassengersQuery::create()
                        ->filterByPrimaryKeys($this->passengerssScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->passengerssScheduledForDeletion = null;
                }
            }

            if ($this->collPassengerss !== null) {
                foreach ($this->collPassengerss as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(EventsTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(EventsTableMap::COL_DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = 'description';
        }
        if ($this->isColumnModified(EventsTableMap::COL_MEETING_POINT)) {
            $modifiedColumns[':p' . $index++]  = 'meeting_point';
        }
        if ($this->isColumnModified(EventsTableMap::COL_DEPARTURE_COORDS)) {
            $modifiedColumns[':p' . $index++]  = 'departure_coords';
        }
        if ($this->isColumnModified(EventsTableMap::COL_EVENT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'event_date';
        }
        if ($this->isColumnModified(EventsTableMap::COL_INSERT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'insert_date';
        }
        if ($this->isColumnModified(EventsTableMap::COL_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'name';
        }
        if ($this->isColumnModified(EventsTableMap::COL_MEETING_POINT_NAME)) {
            $modifiedColumns[':p' . $index++]  = 'meeting_point_name';
        }
        if ($this->isColumnModified(EventsTableMap::COL_ID_FB)) {
            $modifiedColumns[':p' . $index++]  = 'id_fb';
        }
        if ($this->isColumnModified(EventsTableMap::COL_UPDATE_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'update_date';
        }

        $sql = sprintf(
            'INSERT INTO events (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_STR);
                        break;
                    case 'description':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case 'meeting_point':
                        $stmt->bindValue($identifier, $this->meeting_point, PDO::PARAM_STR);
                        break;
                    case 'departure_coords':
                        $stmt->bindValue($identifier, $this->departure_coords, PDO::PARAM_STR);
                        break;
                    case 'event_date':
                        $stmt->bindValue($identifier, $this->event_date ? $this->event_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'insert_date':
                        $stmt->bindValue($identifier, $this->insert_date ? $this->insert_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'name':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case 'meeting_point_name':
                        $stmt->bindValue($identifier, $this->meeting_point_name, PDO::PARAM_STR);
                        break;
                    case 'id_fb':
                        $stmt->bindValue($identifier, $this->id_fb, PDO::PARAM_STR);
                        break;
                    case 'update_date':
                        $stmt->bindValue($identifier, $this->update_date ? $this->update_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getDescription();
                break;
            case 2:
                return $this->getMeetingPoint();
                break;
            case 3:
                return $this->getDepartureCoords();
                break;
            case 4:
                return $this->getEventDate();
                break;
            case 5:
                return $this->getInsertDate();
                break;
            case 6:
                return $this->getName();
                break;
            case 7:
                return $this->getMeetingPointName();
                break;
            case 8:
                return $this->getIdFb();
                break;
            case 9:
                return $this->getUpdateDate();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Events'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Events'][$this->hashCode()] = true;
        $keys = EventsTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getDescription(),
            $keys[2] => $this->getMeetingPoint(),
            $keys[3] => $this->getDepartureCoords(),
            $keys[4] => $this->getEventDate(),
            $keys[5] => $this->getInsertDate(),
            $keys[6] => $this->getName(),
            $keys[7] => $this->getMeetingPointName(),
            $keys[8] => $this->getIdFb(),
            $keys[9] => $this->getUpdateDate(),
        );
        if ($result[$keys[4]] instanceof \DateTimeInterface) {
            $result[$keys[4]] = $result[$keys[4]]->format('c');
        }

        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collCarOrganizations) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'carOrganizations';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'car_organizations';
                        break;
                    default:
                        $key = 'CarOrganizations';
                }

                $result[$key] = $this->collCarOrganizations->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDriverss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'driverss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'driverss';
                        break;
                    default:
                        $key = 'Driverss';
                }

                $result[$key] = $this->collDriverss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPassengerss) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'passengerss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'passengerss';
                        break;
                    default:
                        $key = 'Passengerss';
                }

                $result[$key] = $this->collPassengerss->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Montanari\Propel\Events
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = EventsTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Montanari\Propel\Events
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setDescription($value);
                break;
            case 2:
                $this->setMeetingPoint($value);
                break;
            case 3:
                $this->setDepartureCoords($value);
                break;
            case 4:
                $this->setEventDate($value);
                break;
            case 5:
                $this->setInsertDate($value);
                break;
            case 6:
                $this->setName($value);
                break;
            case 7:
                $this->setMeetingPointName($value);
                break;
            case 8:
                $this->setIdFb($value);
                break;
            case 9:
                $this->setUpdateDate($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = EventsTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setDescription($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setMeetingPoint($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setDepartureCoords($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setEventDate($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setInsertDate($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setName($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setMeetingPointName($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setIdFb($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setUpdateDate($arr[$keys[9]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Montanari\Propel\Events The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(EventsTableMap::DATABASE_NAME);

        if ($this->isColumnModified(EventsTableMap::COL_ID)) {
            $criteria->add(EventsTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(EventsTableMap::COL_DESCRIPTION)) {
            $criteria->add(EventsTableMap::COL_DESCRIPTION, $this->description);
        }
        if ($this->isColumnModified(EventsTableMap::COL_MEETING_POINT)) {
            $criteria->add(EventsTableMap::COL_MEETING_POINT, $this->meeting_point);
        }
        if ($this->isColumnModified(EventsTableMap::COL_DEPARTURE_COORDS)) {
            $criteria->add(EventsTableMap::COL_DEPARTURE_COORDS, $this->departure_coords);
        }
        if ($this->isColumnModified(EventsTableMap::COL_EVENT_DATE)) {
            $criteria->add(EventsTableMap::COL_EVENT_DATE, $this->event_date);
        }
        if ($this->isColumnModified(EventsTableMap::COL_INSERT_DATE)) {
            $criteria->add(EventsTableMap::COL_INSERT_DATE, $this->insert_date);
        }
        if ($this->isColumnModified(EventsTableMap::COL_NAME)) {
            $criteria->add(EventsTableMap::COL_NAME, $this->name);
        }
        if ($this->isColumnModified(EventsTableMap::COL_MEETING_POINT_NAME)) {
            $criteria->add(EventsTableMap::COL_MEETING_POINT_NAME, $this->meeting_point_name);
        }
        if ($this->isColumnModified(EventsTableMap::COL_ID_FB)) {
            $criteria->add(EventsTableMap::COL_ID_FB, $this->id_fb);
        }
        if ($this->isColumnModified(EventsTableMap::COL_UPDATE_DATE)) {
            $criteria->add(EventsTableMap::COL_UPDATE_DATE, $this->update_date);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildEventsQuery::create();
        $criteria->add(EventsTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       string $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Montanari\Propel\Events (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setId($this->getId());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setMeetingPoint($this->getMeetingPoint());
        $copyObj->setDepartureCoords($this->getDepartureCoords());
        $copyObj->setEventDate($this->getEventDate());
        $copyObj->setInsertDate($this->getInsertDate());
        $copyObj->setName($this->getName());
        $copyObj->setMeetingPointName($this->getMeetingPointName());
        $copyObj->setIdFb($this->getIdFb());
        $copyObj->setUpdateDate($this->getUpdateDate());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getCarOrganizations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCarOrganization($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDriverss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDrivers($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPassengerss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPassengers($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Montanari\Propel\Events Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('CarOrganization' == $relationName) {
            $this->initCarOrganizations();
            return;
        }
        if ('Drivers' == $relationName) {
            $this->initDriverss();
            return;
        }
        if ('Passengers' == $relationName) {
            $this->initPassengerss();
            return;
        }
    }

    /**
     * Clears out the collCarOrganizations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addCarOrganizations()
     */
    public function clearCarOrganizations()
    {
        $this->collCarOrganizations = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collCarOrganizations collection loaded partially.
     */
    public function resetPartialCarOrganizations($v = true)
    {
        $this->collCarOrganizationsPartial = $v;
    }

    /**
     * Initializes the collCarOrganizations collection.
     *
     * By default this just sets the collCarOrganizations collection to an empty array (like clearcollCarOrganizations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCarOrganizations($overrideExisting = true)
    {
        if (null !== $this->collCarOrganizations && !$overrideExisting) {
            return;
        }

        $collectionClassName = CarOrganizationTableMap::getTableMap()->getCollectionClassName();

        $this->collCarOrganizations = new $collectionClassName;
        $this->collCarOrganizations->setModel('\Montanari\Propel\CarOrganization');
    }

    /**
     * Gets an array of ChildCarOrganization objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvents is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildCarOrganization[] List of ChildCarOrganization objects
     * @throws PropelException
     */
    public function getCarOrganizations(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collCarOrganizationsPartial && !$this->isNew();
        if (null === $this->collCarOrganizations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCarOrganizations) {
                // return empty collection
                $this->initCarOrganizations();
            } else {
                $collCarOrganizations = ChildCarOrganizationQuery::create(null, $criteria)
                    ->filterByEvents($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collCarOrganizationsPartial && count($collCarOrganizations)) {
                        $this->initCarOrganizations(false);

                        foreach ($collCarOrganizations as $obj) {
                            if (false == $this->collCarOrganizations->contains($obj)) {
                                $this->collCarOrganizations->append($obj);
                            }
                        }

                        $this->collCarOrganizationsPartial = true;
                    }

                    return $collCarOrganizations;
                }

                if ($partial && $this->collCarOrganizations) {
                    foreach ($this->collCarOrganizations as $obj) {
                        if ($obj->isNew()) {
                            $collCarOrganizations[] = $obj;
                        }
                    }
                }

                $this->collCarOrganizations = $collCarOrganizations;
                $this->collCarOrganizationsPartial = false;
            }
        }

        return $this->collCarOrganizations;
    }

    /**
     * Sets a collection of ChildCarOrganization objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $carOrganizations A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvents The current object (for fluent API support)
     */
    public function setCarOrganizations(Collection $carOrganizations, ConnectionInterface $con = null)
    {
        /** @var ChildCarOrganization[] $carOrganizationsToDelete */
        $carOrganizationsToDelete = $this->getCarOrganizations(new Criteria(), $con)->diff($carOrganizations);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->carOrganizationsScheduledForDeletion = clone $carOrganizationsToDelete;

        foreach ($carOrganizationsToDelete as $carOrganizationRemoved) {
            $carOrganizationRemoved->setEvents(null);
        }

        $this->collCarOrganizations = null;
        foreach ($carOrganizations as $carOrganization) {
            $this->addCarOrganization($carOrganization);
        }

        $this->collCarOrganizations = $carOrganizations;
        $this->collCarOrganizationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CarOrganization objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related CarOrganization objects.
     * @throws PropelException
     */
    public function countCarOrganizations(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collCarOrganizationsPartial && !$this->isNew();
        if (null === $this->collCarOrganizations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCarOrganizations) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getCarOrganizations());
            }

            $query = ChildCarOrganizationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvents($this)
                ->count($con);
        }

        return count($this->collCarOrganizations);
    }

    /**
     * Method called to associate a ChildCarOrganization object to this object
     * through the ChildCarOrganization foreign key attribute.
     *
     * @param  ChildCarOrganization $l ChildCarOrganization
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function addCarOrganization(ChildCarOrganization $l)
    {
        if ($this->collCarOrganizations === null) {
            $this->initCarOrganizations();
            $this->collCarOrganizationsPartial = true;
        }

        if (!$this->collCarOrganizations->contains($l)) {
            $this->doAddCarOrganization($l);

            if ($this->carOrganizationsScheduledForDeletion and $this->carOrganizationsScheduledForDeletion->contains($l)) {
                $this->carOrganizationsScheduledForDeletion->remove($this->carOrganizationsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildCarOrganization $carOrganization The ChildCarOrganization object to add.
     */
    protected function doAddCarOrganization(ChildCarOrganization $carOrganization)
    {
        $this->collCarOrganizations[]= $carOrganization;
        $carOrganization->setEvents($this);
    }

    /**
     * @param  ChildCarOrganization $carOrganization The ChildCarOrganization object to remove.
     * @return $this|ChildEvents The current object (for fluent API support)
     */
    public function removeCarOrganization(ChildCarOrganization $carOrganization)
    {
        if ($this->getCarOrganizations()->contains($carOrganization)) {
            $pos = $this->collCarOrganizations->search($carOrganization);
            $this->collCarOrganizations->remove($pos);
            if (null === $this->carOrganizationsScheduledForDeletion) {
                $this->carOrganizationsScheduledForDeletion = clone $this->collCarOrganizations;
                $this->carOrganizationsScheduledForDeletion->clear();
            }
            $this->carOrganizationsScheduledForDeletion[]= clone $carOrganization;
            $carOrganization->setEvents(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Events is new, it will return
     * an empty collection; or if this Events has previously
     * been saved, it will retrieve related CarOrganizations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Events.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCarOrganization[] List of ChildCarOrganization objects
     */
    public function getCarOrganizationsJoinDriver(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCarOrganizationQuery::create(null, $criteria);
        $query->joinWith('Driver', $joinBehavior);

        return $this->getCarOrganizations($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Events is new, it will return
     * an empty collection; or if this Events has previously
     * been saved, it will retrieve related CarOrganizations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Events.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildCarOrganization[] List of ChildCarOrganization objects
     */
    public function getCarOrganizationsJoinPassenger(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildCarOrganizationQuery::create(null, $criteria);
        $query->joinWith('Passenger', $joinBehavior);

        return $this->getCarOrganizations($query, $con);
    }

    /**
     * Clears out the collDriverss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addDriverss()
     */
    public function clearDriverss()
    {
        $this->collDriverss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collDriverss collection loaded partially.
     */
    public function resetPartialDriverss($v = true)
    {
        $this->collDriverssPartial = $v;
    }

    /**
     * Initializes the collDriverss collection.
     *
     * By default this just sets the collDriverss collection to an empty array (like clearcollDriverss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDriverss($overrideExisting = true)
    {
        if (null !== $this->collDriverss && !$overrideExisting) {
            return;
        }

        $collectionClassName = DriversTableMap::getTableMap()->getCollectionClassName();

        $this->collDriverss = new $collectionClassName;
        $this->collDriverss->setModel('\Montanari\Propel\Drivers');
    }

    /**
     * Gets an array of ChildDrivers objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvents is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildDrivers[] List of ChildDrivers objects
     * @throws PropelException
     */
    public function getDriverss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collDriverssPartial && !$this->isNew();
        if (null === $this->collDriverss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDriverss) {
                // return empty collection
                $this->initDriverss();
            } else {
                $collDriverss = ChildDriversQuery::create(null, $criteria)
                    ->filterByEvents($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collDriverssPartial && count($collDriverss)) {
                        $this->initDriverss(false);

                        foreach ($collDriverss as $obj) {
                            if (false == $this->collDriverss->contains($obj)) {
                                $this->collDriverss->append($obj);
                            }
                        }

                        $this->collDriverssPartial = true;
                    }

                    return $collDriverss;
                }

                if ($partial && $this->collDriverss) {
                    foreach ($this->collDriverss as $obj) {
                        if ($obj->isNew()) {
                            $collDriverss[] = $obj;
                        }
                    }
                }

                $this->collDriverss = $collDriverss;
                $this->collDriverssPartial = false;
            }
        }

        return $this->collDriverss;
    }

    /**
     * Sets a collection of ChildDrivers objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $driverss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvents The current object (for fluent API support)
     */
    public function setDriverss(Collection $driverss, ConnectionInterface $con = null)
    {
        /** @var ChildDrivers[] $driverssToDelete */
        $driverssToDelete = $this->getDriverss(new Criteria(), $con)->diff($driverss);


        $this->driverssScheduledForDeletion = $driverssToDelete;

        foreach ($driverssToDelete as $driversRemoved) {
            $driversRemoved->setEvents(null);
        }

        $this->collDriverss = null;
        foreach ($driverss as $drivers) {
            $this->addDrivers($drivers);
        }

        $this->collDriverss = $driverss;
        $this->collDriverssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Drivers objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Drivers objects.
     * @throws PropelException
     */
    public function countDriverss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collDriverssPartial && !$this->isNew();
        if (null === $this->collDriverss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDriverss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getDriverss());
            }

            $query = ChildDriversQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvents($this)
                ->count($con);
        }

        return count($this->collDriverss);
    }

    /**
     * Method called to associate a ChildDrivers object to this object
     * through the ChildDrivers foreign key attribute.
     *
     * @param  ChildDrivers $l ChildDrivers
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function addDrivers(ChildDrivers $l)
    {
        if ($this->collDriverss === null) {
            $this->initDriverss();
            $this->collDriverssPartial = true;
        }

        if (!$this->collDriverss->contains($l)) {
            $this->doAddDrivers($l);

            if ($this->driverssScheduledForDeletion and $this->driverssScheduledForDeletion->contains($l)) {
                $this->driverssScheduledForDeletion->remove($this->driverssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildDrivers $drivers The ChildDrivers object to add.
     */
    protected function doAddDrivers(ChildDrivers $drivers)
    {
        $this->collDriverss[]= $drivers;
        $drivers->setEvents($this);
    }

    /**
     * @param  ChildDrivers $drivers The ChildDrivers object to remove.
     * @return $this|ChildEvents The current object (for fluent API support)
     */
    public function removeDrivers(ChildDrivers $drivers)
    {
        if ($this->getDriverss()->contains($drivers)) {
            $pos = $this->collDriverss->search($drivers);
            $this->collDriverss->remove($pos);
            if (null === $this->driverssScheduledForDeletion) {
                $this->driverssScheduledForDeletion = clone $this->collDriverss;
                $this->driverssScheduledForDeletion->clear();
            }
            $this->driverssScheduledForDeletion[]= clone $drivers;
            $drivers->setEvents(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Events is new, it will return
     * an empty collection; or if this Events has previously
     * been saved, it will retrieve related Driverss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Events.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDrivers[] List of ChildDrivers objects
     */
    public function getDriverssJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDriversQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getDriverss($query, $con);
    }

    /**
     * Clears out the collPassengerss collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPassengerss()
     */
    public function clearPassengerss()
    {
        $this->collPassengerss = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPassengerss collection loaded partially.
     */
    public function resetPartialPassengerss($v = true)
    {
        $this->collPassengerssPartial = $v;
    }

    /**
     * Initializes the collPassengerss collection.
     *
     * By default this just sets the collPassengerss collection to an empty array (like clearcollPassengerss());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPassengerss($overrideExisting = true)
    {
        if (null !== $this->collPassengerss && !$overrideExisting) {
            return;
        }

        $collectionClassName = PassengersTableMap::getTableMap()->getCollectionClassName();

        $this->collPassengerss = new $collectionClassName;
        $this->collPassengerss->setModel('\Montanari\Propel\Passengers');
    }

    /**
     * Gets an array of ChildPassengers objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildEvents is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPassengers[] List of ChildPassengers objects
     * @throws PropelException
     */
    public function getPassengerss(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPassengerssPartial && !$this->isNew();
        if (null === $this->collPassengerss || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPassengerss) {
                // return empty collection
                $this->initPassengerss();
            } else {
                $collPassengerss = ChildPassengersQuery::create(null, $criteria)
                    ->filterByEvents($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPassengerssPartial && count($collPassengerss)) {
                        $this->initPassengerss(false);

                        foreach ($collPassengerss as $obj) {
                            if (false == $this->collPassengerss->contains($obj)) {
                                $this->collPassengerss->append($obj);
                            }
                        }

                        $this->collPassengerssPartial = true;
                    }

                    return $collPassengerss;
                }

                if ($partial && $this->collPassengerss) {
                    foreach ($this->collPassengerss as $obj) {
                        if ($obj->isNew()) {
                            $collPassengerss[] = $obj;
                        }
                    }
                }

                $this->collPassengerss = $collPassengerss;
                $this->collPassengerssPartial = false;
            }
        }

        return $this->collPassengerss;
    }

    /**
     * Sets a collection of ChildPassengers objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $passengerss A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildEvents The current object (for fluent API support)
     */
    public function setPassengerss(Collection $passengerss, ConnectionInterface $con = null)
    {
        /** @var ChildPassengers[] $passengerssToDelete */
        $passengerssToDelete = $this->getPassengerss(new Criteria(), $con)->diff($passengerss);


        $this->passengerssScheduledForDeletion = $passengerssToDelete;

        foreach ($passengerssToDelete as $passengersRemoved) {
            $passengersRemoved->setEvents(null);
        }

        $this->collPassengerss = null;
        foreach ($passengerss as $passengers) {
            $this->addPassengers($passengers);
        }

        $this->collPassengerss = $passengerss;
        $this->collPassengerssPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Passengers objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Passengers objects.
     * @throws PropelException
     */
    public function countPassengerss(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPassengerssPartial && !$this->isNew();
        if (null === $this->collPassengerss || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPassengerss) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPassengerss());
            }

            $query = ChildPassengersQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByEvents($this)
                ->count($con);
        }

        return count($this->collPassengerss);
    }

    /**
     * Method called to associate a ChildPassengers object to this object
     * through the ChildPassengers foreign key attribute.
     *
     * @param  ChildPassengers $l ChildPassengers
     * @return $this|\Montanari\Propel\Events The current object (for fluent API support)
     */
    public function addPassengers(ChildPassengers $l)
    {
        if ($this->collPassengerss === null) {
            $this->initPassengerss();
            $this->collPassengerssPartial = true;
        }

        if (!$this->collPassengerss->contains($l)) {
            $this->doAddPassengers($l);

            if ($this->passengerssScheduledForDeletion and $this->passengerssScheduledForDeletion->contains($l)) {
                $this->passengerssScheduledForDeletion->remove($this->passengerssScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPassengers $passengers The ChildPassengers object to add.
     */
    protected function doAddPassengers(ChildPassengers $passengers)
    {
        $this->collPassengerss[]= $passengers;
        $passengers->setEvents($this);
    }

    /**
     * @param  ChildPassengers $passengers The ChildPassengers object to remove.
     * @return $this|ChildEvents The current object (for fluent API support)
     */
    public function removePassengers(ChildPassengers $passengers)
    {
        if ($this->getPassengerss()->contains($passengers)) {
            $pos = $this->collPassengerss->search($passengers);
            $this->collPassengerss->remove($pos);
            if (null === $this->passengerssScheduledForDeletion) {
                $this->passengerssScheduledForDeletion = clone $this->collPassengerss;
                $this->passengerssScheduledForDeletion->clear();
            }
            $this->passengerssScheduledForDeletion[]= clone $passengers;
            $passengers->setEvents(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Events is new, it will return
     * an empty collection; or if this Events has previously
     * been saved, it will retrieve related Passengerss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Events.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPassengers[] List of ChildPassengers objects
     */
    public function getPassengerssJoinUsers(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPassengersQuery::create(null, $criteria);
        $query->joinWith('Users', $joinBehavior);

        return $this->getPassengerss($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->description = null;
        $this->meeting_point = null;
        $this->departure_coords = null;
        $this->event_date = null;
        $this->insert_date = null;
        $this->name = null;
        $this->meeting_point_name = null;
        $this->id_fb = null;
        $this->update_date = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collCarOrganizations) {
                foreach ($this->collCarOrganizations as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDriverss) {
                foreach ($this->collDriverss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPassengerss) {
                foreach ($this->collPassengerss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collCarOrganizations = null;
        $this->collDriverss = null;
        $this->collPassengerss = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(EventsTableMap::DEFAULT_STRING_FORMAT);
    }

    // timestampable behavior

    /**
     * Mark the current object so that the update date doesn't get updated during next save
     *
     * @return     $this|ChildEvents The current object (for fluent API support)
     */
    public function keepUpdateDateUnchanged()
    {
        $this->modifiedColumns[EventsTableMap::COL_UPDATE_DATE] = true;

        return $this;
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preSave')) {
            return parent::preSave($con);
        }
        return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postSave')) {
            parent::postSave($con);
        }
    }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preInsert')) {
            return parent::preInsert($con);
        }
        return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postInsert')) {
            parent::postInsert($con);
        }
    }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preUpdate')) {
            return parent::preUpdate($con);
        }
        return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postUpdate')) {
            parent::postUpdate($con);
        }
    }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::preDelete')) {
            return parent::preDelete($con);
        }
        return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
        if (is_callable('parent::postDelete')) {
            parent::postDelete($con);
        }
    }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
