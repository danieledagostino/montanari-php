<?php

namespace Montanari\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use Montanari\Propel\Messages as ChildMessages;
use Montanari\Propel\MessagesQuery as ChildMessagesQuery;
use Montanari\Propel\Users as ChildUsers;
use Montanari\Propel\UsersQuery as ChildUsersQuery;
use Montanari\Propel\Map\MessagesTableMap;
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
 * Base class that represents a row from the 'messages' table.
 *
 *
 *
 * @package    propel.generator.Montanari.Propel.Base
 */
abstract class Messages implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Montanari\\Propel\\Map\\MessagesTableMap';


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
     * The value for the id_user_from field.
     *
     * @var        int
     */
    protected $id_user_from;

    /**
     * The value for the id_user_to field.
     *
     * @var        int
     */
    protected $id_user_to;

    /**
     * The value for the message field.
     *
     * @var        string
     */
    protected $message;

    /**
     * The value for the read field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $read;

    /**
     * The value for the delete field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $delete;

    /**
     * The value for the insert_date field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $insert_date;

    /**
     * The value for the type field.
     *
     * @var        string
     */
    protected $type;

    /**
     * The value for the subject field.
     *
     * @var        string
     */
    protected $subject;

    /**
     * The value for the parent field.
     *
     * @var        string
     */
    protected $parent;

    /**
     * @var        ChildUsers
     */
    protected $aUserFrom;

    /**
     * @var        ChildUsers
     */
    protected $aUserTo;

    /**
     * @var        ChildMessages
     */
    protected $aParentTo;

    /**
     * @var        ObjectCollection|ChildMessages[] Collection to store aggregation of ChildMessages objects.
     */
    protected $collMessagessRelatedById;
    protected $collMessagessRelatedByIdPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMessages[]
     */
    protected $messagessRelatedByIdScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->read = false;
        $this->delete = false;
    }

    /**
     * Initializes internal state of Montanari\Propel\Base\Messages object.
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
     * Compares this with another <code>Messages</code> instance.  If
     * <code>obj</code> is an instance of <code>Messages</code>, delegates to
     * <code>equals(Messages)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Messages The current object, for fluid interface
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
     * Get the [id_user_from] column value.
     *
     * @return int
     */
    public function getIdUserFrom()
    {
        return $this->id_user_from;
    }

    /**
     * Get the [id_user_to] column value.
     *
     * @return int
     */
    public function getIdUserTo()
    {
        return $this->id_user_to;
    }

    /**
     * Get the [message] column value.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Get the [read] column value.
     *
     * @return boolean
     */
    public function getRead()
    {
        return $this->read;
    }

    /**
     * Get the [read] column value.
     *
     * @return boolean
     */
    public function isRead()
    {
        return $this->getRead();
    }

    /**
     * Get the [delete] column value.
     *
     * @return boolean
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Get the [delete] column value.
     *
     * @return boolean
     */
    public function isDelete()
    {
        return $this->getDelete();
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
     * Get the [type] column value.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get the [subject] column value.
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get the [parent] column value.
     *
     * @return string
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set the value of [id] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[MessagesTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [id_user_from] column.
     *
     * @param int $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setIdUserFrom($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_user_from !== $v) {
            $this->id_user_from = $v;
            $this->modifiedColumns[MessagesTableMap::COL_ID_USER_FROM] = true;
        }

        if ($this->aUserFrom !== null && $this->aUserFrom->getId() !== $v) {
            $this->aUserFrom = null;
        }

        return $this;
    } // setIdUserFrom()

    /**
     * Set the value of [id_user_to] column.
     *
     * @param int $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setIdUserTo($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id_user_to !== $v) {
            $this->id_user_to = $v;
            $this->modifiedColumns[MessagesTableMap::COL_ID_USER_TO] = true;
        }

        if ($this->aUserTo !== null && $this->aUserTo->getId() !== $v) {
            $this->aUserTo = null;
        }

        return $this;
    } // setIdUserTo()

    /**
     * Set the value of [message] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setMessage($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->message !== $v) {
            $this->message = $v;
            $this->modifiedColumns[MessagesTableMap::COL_MESSAGE] = true;
        }

        return $this;
    } // setMessage()

    /**
     * Sets the value of the [read] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setRead($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->read !== $v) {
            $this->read = $v;
            $this->modifiedColumns[MessagesTableMap::COL_READ] = true;
        }

        return $this;
    } // setRead()

    /**
     * Sets the value of the [delete] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setDelete($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->delete !== $v) {
            $this->delete = $v;
            $this->modifiedColumns[MessagesTableMap::COL_DELETE] = true;
        }

        return $this;
    } // setDelete()

    /**
     * Sets the value of [insert_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setInsertDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->insert_date !== null || $dt !== null) {
            if ($this->insert_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->insert_date->format("Y-m-d H:i:s.u")) {
                $this->insert_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[MessagesTableMap::COL_INSERT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInsertDate()

    /**
     * Set the value of [type] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setType($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->type !== $v) {
            $this->type = $v;
            $this->modifiedColumns[MessagesTableMap::COL_TYPE] = true;
        }

        return $this;
    } // setType()

    /**
     * Set the value of [subject] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setSubject($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->subject !== $v) {
            $this->subject = $v;
            $this->modifiedColumns[MessagesTableMap::COL_SUBJECT] = true;
        }

        return $this;
    } // setSubject()

    /**
     * Set the value of [parent] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function setParent($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->parent !== $v) {
            $this->parent = $v;
            $this->modifiedColumns[MessagesTableMap::COL_PARENT] = true;
        }

        if ($this->aParentTo !== null && $this->aParentTo->getId() !== $v) {
            $this->aParentTo = null;
        }

        return $this;
    } // setParent()

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
            if ($this->read !== false) {
                return false;
            }

            if ($this->delete !== false) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : MessagesTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : MessagesTableMap::translateFieldName('IdUserFrom', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_user_from = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : MessagesTableMap::translateFieldName('IdUserTo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_user_to = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : MessagesTableMap::translateFieldName('Message', TableMap::TYPE_PHPNAME, $indexType)];
            $this->message = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : MessagesTableMap::translateFieldName('Read', TableMap::TYPE_PHPNAME, $indexType)];
            $this->read = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : MessagesTableMap::translateFieldName('Delete', TableMap::TYPE_PHPNAME, $indexType)];
            $this->delete = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : MessagesTableMap::translateFieldName('InsertDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->insert_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : MessagesTableMap::translateFieldName('Type', TableMap::TYPE_PHPNAME, $indexType)];
            $this->type = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : MessagesTableMap::translateFieldName('Subject', TableMap::TYPE_PHPNAME, $indexType)];
            $this->subject = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : MessagesTableMap::translateFieldName('Parent', TableMap::TYPE_PHPNAME, $indexType)];
            $this->parent = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 10; // 10 = MessagesTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Montanari\\Propel\\Messages'), 0, $e);
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
        if ($this->aUserFrom !== null && $this->id_user_from !== $this->aUserFrom->getId()) {
            $this->aUserFrom = null;
        }
        if ($this->aUserTo !== null && $this->id_user_to !== $this->aUserTo->getId()) {
            $this->aUserTo = null;
        }
        if ($this->aParentTo !== null && $this->parent !== $this->aParentTo->getId()) {
            $this->aParentTo = null;
        }
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
            $con = Propel::getServiceContainer()->getReadConnection(MessagesTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildMessagesQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aUserFrom = null;
            $this->aUserTo = null;
            $this->aParentTo = null;
            $this->collMessagessRelatedById = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Messages::setDeleted()
     * @see Messages::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildMessagesQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(MessagesTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                MessagesTableMap::addInstanceToPool($this);
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

            // We call the save method on the following object(s) if they
            // were passed to this object by their corresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aUserFrom !== null) {
                if ($this->aUserFrom->isModified() || $this->aUserFrom->isNew()) {
                    $affectedRows += $this->aUserFrom->save($con);
                }
                $this->setUserFrom($this->aUserFrom);
            }

            if ($this->aUserTo !== null) {
                if ($this->aUserTo->isModified() || $this->aUserTo->isNew()) {
                    $affectedRows += $this->aUserTo->save($con);
                }
                $this->setUserTo($this->aUserTo);
            }

            if ($this->aParentTo !== null) {
                if ($this->aParentTo->isModified() || $this->aParentTo->isNew()) {
                    $affectedRows += $this->aParentTo->save($con);
                }
                $this->setParentTo($this->aParentTo);
            }

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

            if ($this->messagessRelatedByIdScheduledForDeletion !== null) {
                if (!$this->messagessRelatedByIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->messagessRelatedByIdScheduledForDeletion as $messagesRelatedById) {
                        // need to save related object because we set the relation to null
                        $messagesRelatedById->save($con);
                    }
                    $this->messagessRelatedByIdScheduledForDeletion = null;
                }
            }

            if ($this->collMessagessRelatedById !== null) {
                foreach ($this->collMessagessRelatedById as $referrerFK) {
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

        $this->modifiedColumns[MessagesTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MessagesTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MessagesTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = '`id`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_ID_USER_FROM)) {
            $modifiedColumns[':p' . $index++]  = '`id_user_from`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_ID_USER_TO)) {
            $modifiedColumns[':p' . $index++]  = '`id_user_to`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_MESSAGE)) {
            $modifiedColumns[':p' . $index++]  = '`message`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_READ)) {
            $modifiedColumns[':p' . $index++]  = '`read`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_DELETE)) {
            $modifiedColumns[':p' . $index++]  = '`delete`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_INSERT_DATE)) {
            $modifiedColumns[':p' . $index++]  = '`insert_date`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_TYPE)) {
            $modifiedColumns[':p' . $index++]  = '`type`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_SUBJECT)) {
            $modifiedColumns[':p' . $index++]  = '`subject`';
        }
        if ($this->isColumnModified(MessagesTableMap::COL_PARENT)) {
            $modifiedColumns[':p' . $index++]  = '`parent`';
        }

        $sql = sprintf(
            'INSERT INTO `messages` (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '`id`':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case '`id_user_from`':
                        $stmt->bindValue($identifier, $this->id_user_from, PDO::PARAM_INT);
                        break;
                    case '`id_user_to`':
                        $stmt->bindValue($identifier, $this->id_user_to, PDO::PARAM_INT);
                        break;
                    case '`message`':
                        $stmt->bindValue($identifier, $this->message, PDO::PARAM_STR);
                        break;
                    case '`read`':
                        $stmt->bindValue($identifier, (int) $this->read, PDO::PARAM_INT);
                        break;
                    case '`delete`':
                        $stmt->bindValue($identifier, (int) $this->delete, PDO::PARAM_INT);
                        break;
                    case '`insert_date`':
                        $stmt->bindValue($identifier, $this->insert_date ? $this->insert_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case '`type`':
                        $stmt->bindValue($identifier, $this->type, PDO::PARAM_STR);
                        break;
                    case '`subject`':
                        $stmt->bindValue($identifier, $this->subject, PDO::PARAM_STR);
                        break;
                    case '`parent`':
                        $stmt->bindValue($identifier, $this->parent, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

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
        $pos = MessagesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getIdUserFrom();
                break;
            case 2:
                return $this->getIdUserTo();
                break;
            case 3:
                return $this->getMessage();
                break;
            case 4:
                return $this->getRead();
                break;
            case 5:
                return $this->getDelete();
                break;
            case 6:
                return $this->getInsertDate();
                break;
            case 7:
                return $this->getType();
                break;
            case 8:
                return $this->getSubject();
                break;
            case 9:
                return $this->getParent();
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

        if (isset($alreadyDumpedObjects['Messages'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Messages'][$this->hashCode()] = true;
        $keys = MessagesTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getIdUserFrom(),
            $keys[2] => $this->getIdUserTo(),
            $keys[3] => $this->getMessage(),
            $keys[4] => $this->getRead(),
            $keys[5] => $this->getDelete(),
            $keys[6] => $this->getInsertDate(),
            $keys[7] => $this->getType(),
            $keys[8] => $this->getSubject(),
            $keys[9] => $this->getParent(),
        );
        if ($result[$keys[6]] instanceof \DateTimeInterface) {
            $result[$keys[6]] = $result[$keys[6]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->aUserFrom) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'UserFrom';
                }

                $result[$key] = $this->aUserFrom->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aUserTo) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'users';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'users';
                        break;
                    default:
                        $key = 'UserTo';
                }

                $result[$key] = $this->aUserTo->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aParentTo) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'messages';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'messages';
                        break;
                    default:
                        $key = 'ParentTo';
                }

                $result[$key] = $this->aParentTo->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collMessagessRelatedById) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'messagess';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'messagess';
                        break;
                    default:
                        $key = 'Messagess';
                }

                $result[$key] = $this->collMessagessRelatedById->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
     * @return $this|\Montanari\Propel\Messages
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = MessagesTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Montanari\Propel\Messages
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setIdUserFrom($value);
                break;
            case 2:
                $this->setIdUserTo($value);
                break;
            case 3:
                $this->setMessage($value);
                break;
            case 4:
                $this->setRead($value);
                break;
            case 5:
                $this->setDelete($value);
                break;
            case 6:
                $this->setInsertDate($value);
                break;
            case 7:
                $this->setType($value);
                break;
            case 8:
                $this->setSubject($value);
                break;
            case 9:
                $this->setParent($value);
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
        $keys = MessagesTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setIdUserFrom($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setIdUserTo($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setMessage($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setRead($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDelete($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setInsertDate($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setType($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setSubject($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setParent($arr[$keys[9]]);
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
     * @return $this|\Montanari\Propel\Messages The current object, for fluid interface
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
        $criteria = new Criteria(MessagesTableMap::DATABASE_NAME);

        if ($this->isColumnModified(MessagesTableMap::COL_ID)) {
            $criteria->add(MessagesTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_ID_USER_FROM)) {
            $criteria->add(MessagesTableMap::COL_ID_USER_FROM, $this->id_user_from);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_ID_USER_TO)) {
            $criteria->add(MessagesTableMap::COL_ID_USER_TO, $this->id_user_to);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_MESSAGE)) {
            $criteria->add(MessagesTableMap::COL_MESSAGE, $this->message);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_READ)) {
            $criteria->add(MessagesTableMap::COL_READ, $this->read);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_DELETE)) {
            $criteria->add(MessagesTableMap::COL_DELETE, $this->delete);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_INSERT_DATE)) {
            $criteria->add(MessagesTableMap::COL_INSERT_DATE, $this->insert_date);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_TYPE)) {
            $criteria->add(MessagesTableMap::COL_TYPE, $this->type);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_SUBJECT)) {
            $criteria->add(MessagesTableMap::COL_SUBJECT, $this->subject);
        }
        if ($this->isColumnModified(MessagesTableMap::COL_PARENT)) {
            $criteria->add(MessagesTableMap::COL_PARENT, $this->parent);
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
        $criteria = ChildMessagesQuery::create();
        $criteria->add(MessagesTableMap::COL_ID, $this->id);

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
     * @param      object $copyObj An object of \Montanari\Propel\Messages (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setIdUserFrom($this->getIdUserFrom());
        $copyObj->setIdUserTo($this->getIdUserTo());
        $copyObj->setMessage($this->getMessage());
        $copyObj->setRead($this->getRead());
        $copyObj->setDelete($this->getDelete());
        $copyObj->setInsertDate($this->getInsertDate());
        $copyObj->setType($this->getType());
        $copyObj->setSubject($this->getSubject());
        $copyObj->setParent($this->getParent());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getMessagessRelatedById() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMessagesRelatedById($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
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
     * @return \Montanari\Propel\Messages Clone of current object.
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
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserFrom(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setIdUserFrom(NULL);
        } else {
            $this->setIdUserFrom($v->getId());
        }

        $this->aUserFrom = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addMessagesRelatedByIdUserFrom($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getUserFrom(ConnectionInterface $con = null)
    {
        if ($this->aUserFrom === null && ($this->id_user_from != 0)) {
            $this->aUserFrom = ChildUsersQuery::create()->findPk($this->id_user_from, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserFrom->addMessagessRelatedByIdUserFrom($this);
             */
        }

        return $this->aUserFrom;
    }

    /**
     * Declares an association between this object and a ChildUsers object.
     *
     * @param  ChildUsers $v
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserTo(ChildUsers $v = null)
    {
        if ($v === null) {
            $this->setIdUserTo(NULL);
        } else {
            $this->setIdUserTo($v->getId());
        }

        $this->aUserTo = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildUsers object, it will not be re-added.
        if ($v !== null) {
            $v->addMessagesRelatedByIdUserTo($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildUsers object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildUsers The associated ChildUsers object.
     * @throws PropelException
     */
    public function getUserTo(ConnectionInterface $con = null)
    {
        if ($this->aUserTo === null && ($this->id_user_to != 0)) {
            $this->aUserTo = ChildUsersQuery::create()->findPk($this->id_user_to, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aUserTo->addMessagessRelatedByIdUserTo($this);
             */
        }

        return $this->aUserTo;
    }

    /**
     * Declares an association between this object and a ChildMessages object.
     *
     * @param  ChildMessages $v
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     * @throws PropelException
     */
    public function setParentTo(ChildMessages $v = null)
    {
        if ($v === null) {
            $this->setParent(NULL);
        } else {
            $this->setParent($v->getId());
        }

        $this->aParentTo = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the ChildMessages object, it will not be re-added.
        if ($v !== null) {
            $v->addMessagesRelatedById($this);
        }


        return $this;
    }


    /**
     * Get the associated ChildMessages object
     *
     * @param  ConnectionInterface $con Optional Connection object.
     * @return ChildMessages The associated ChildMessages object.
     * @throws PropelException
     */
    public function getParentTo(ConnectionInterface $con = null)
    {
        if ($this->aParentTo === null && (($this->parent !== "" && $this->parent !== null))) {
            $this->aParentTo = ChildMessagesQuery::create()->findPk($this->parent, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aParentTo->addMessagessRelatedById($this);
             */
        }

        return $this->aParentTo;
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
        if ('MessagesRelatedById' == $relationName) {
            $this->initMessagessRelatedById();
            return;
        }
    }

    /**
     * Clears out the collMessagessRelatedById collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMessagessRelatedById()
     */
    public function clearMessagessRelatedById()
    {
        $this->collMessagessRelatedById = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMessagessRelatedById collection loaded partially.
     */
    public function resetPartialMessagessRelatedById($v = true)
    {
        $this->collMessagessRelatedByIdPartial = $v;
    }

    /**
     * Initializes the collMessagessRelatedById collection.
     *
     * By default this just sets the collMessagessRelatedById collection to an empty array (like clearcollMessagessRelatedById());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMessagessRelatedById($overrideExisting = true)
    {
        if (null !== $this->collMessagessRelatedById && !$overrideExisting) {
            return;
        }

        $collectionClassName = MessagesTableMap::getTableMap()->getCollectionClassName();

        $this->collMessagessRelatedById = new $collectionClassName;
        $this->collMessagessRelatedById->setModel('\Montanari\Propel\Messages');
    }

    /**
     * Gets an array of ChildMessages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildMessages is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     * @throws PropelException
     */
    public function getMessagessRelatedById(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMessagessRelatedByIdPartial && !$this->isNew();
        if (null === $this->collMessagessRelatedById || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMessagessRelatedById) {
                // return empty collection
                $this->initMessagessRelatedById();
            } else {
                $collMessagessRelatedById = ChildMessagesQuery::create(null, $criteria)
                    ->filterByParentTo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMessagessRelatedByIdPartial && count($collMessagessRelatedById)) {
                        $this->initMessagessRelatedById(false);

                        foreach ($collMessagessRelatedById as $obj) {
                            if (false == $this->collMessagessRelatedById->contains($obj)) {
                                $this->collMessagessRelatedById->append($obj);
                            }
                        }

                        $this->collMessagessRelatedByIdPartial = true;
                    }

                    return $collMessagessRelatedById;
                }

                if ($partial && $this->collMessagessRelatedById) {
                    foreach ($this->collMessagessRelatedById as $obj) {
                        if ($obj->isNew()) {
                            $collMessagessRelatedById[] = $obj;
                        }
                    }
                }

                $this->collMessagessRelatedById = $collMessagessRelatedById;
                $this->collMessagessRelatedByIdPartial = false;
            }
        }

        return $this->collMessagessRelatedById;
    }

    /**
     * Sets a collection of ChildMessages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $messagessRelatedById A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildMessages The current object (for fluent API support)
     */
    public function setMessagessRelatedById(Collection $messagessRelatedById, ConnectionInterface $con = null)
    {
        /** @var ChildMessages[] $messagessRelatedByIdToDelete */
        $messagessRelatedByIdToDelete = $this->getMessagessRelatedById(new Criteria(), $con)->diff($messagessRelatedById);


        $this->messagessRelatedByIdScheduledForDeletion = $messagessRelatedByIdToDelete;

        foreach ($messagessRelatedByIdToDelete as $messagesRelatedByIdRemoved) {
            $messagesRelatedByIdRemoved->setParentTo(null);
        }

        $this->collMessagessRelatedById = null;
        foreach ($messagessRelatedById as $messagesRelatedById) {
            $this->addMessagesRelatedById($messagesRelatedById);
        }

        $this->collMessagessRelatedById = $messagessRelatedById;
        $this->collMessagessRelatedByIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Messages objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related Messages objects.
     * @throws PropelException
     */
    public function countMessagessRelatedById(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMessagessRelatedByIdPartial && !$this->isNew();
        if (null === $this->collMessagessRelatedById || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMessagessRelatedById) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMessagessRelatedById());
            }

            $query = ChildMessagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByParentTo($this)
                ->count($con);
        }

        return count($this->collMessagessRelatedById);
    }

    /**
     * Method called to associate a ChildMessages object to this object
     * through the ChildMessages foreign key attribute.
     *
     * @param  ChildMessages $l ChildMessages
     * @return $this|\Montanari\Propel\Messages The current object (for fluent API support)
     */
    public function addMessagesRelatedById(ChildMessages $l)
    {
        if ($this->collMessagessRelatedById === null) {
            $this->initMessagessRelatedById();
            $this->collMessagessRelatedByIdPartial = true;
        }

        if (!$this->collMessagessRelatedById->contains($l)) {
            $this->doAddMessagesRelatedById($l);

            if ($this->messagessRelatedByIdScheduledForDeletion and $this->messagessRelatedByIdScheduledForDeletion->contains($l)) {
                $this->messagessRelatedByIdScheduledForDeletion->remove($this->messagessRelatedByIdScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMessages $messagesRelatedById The ChildMessages object to add.
     */
    protected function doAddMessagesRelatedById(ChildMessages $messagesRelatedById)
    {
        $this->collMessagessRelatedById[]= $messagesRelatedById;
        $messagesRelatedById->setParentTo($this);
    }

    /**
     * @param  ChildMessages $messagesRelatedById The ChildMessages object to remove.
     * @return $this|ChildMessages The current object (for fluent API support)
     */
    public function removeMessagesRelatedById(ChildMessages $messagesRelatedById)
    {
        if ($this->getMessagessRelatedById()->contains($messagesRelatedById)) {
            $pos = $this->collMessagessRelatedById->search($messagesRelatedById);
            $this->collMessagessRelatedById->remove($pos);
            if (null === $this->messagessRelatedByIdScheduledForDeletion) {
                $this->messagessRelatedByIdScheduledForDeletion = clone $this->collMessagessRelatedById;
                $this->messagessRelatedByIdScheduledForDeletion->clear();
            }
            $this->messagessRelatedByIdScheduledForDeletion[]= $messagesRelatedById;
            $messagesRelatedById->setParentTo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Messages is new, it will return
     * an empty collection; or if this Messages has previously
     * been saved, it will retrieve related MessagessRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Messages.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     */
    public function getMessagessRelatedByIdJoinUserFrom(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMessagesQuery::create(null, $criteria);
        $query->joinWith('UserFrom', $joinBehavior);

        return $this->getMessagessRelatedById($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Messages is new, it will return
     * an empty collection; or if this Messages has previously
     * been saved, it will retrieve related MessagessRelatedById from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Messages.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     */
    public function getMessagessRelatedByIdJoinUserTo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMessagesQuery::create(null, $criteria);
        $query->joinWith('UserTo', $joinBehavior);

        return $this->getMessagessRelatedById($query, $con);
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        if (null !== $this->aUserFrom) {
            $this->aUserFrom->removeMessagesRelatedByIdUserFrom($this);
        }
        if (null !== $this->aUserTo) {
            $this->aUserTo->removeMessagesRelatedByIdUserTo($this);
        }
        if (null !== $this->aParentTo) {
            $this->aParentTo->removeMessagesRelatedById($this);
        }
        $this->id = null;
        $this->id_user_from = null;
        $this->id_user_to = null;
        $this->message = null;
        $this->read = null;
        $this->delete = null;
        $this->insert_date = null;
        $this->type = null;
        $this->subject = null;
        $this->parent = null;
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
            if ($this->collMessagessRelatedById) {
                foreach ($this->collMessagessRelatedById as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collMessagessRelatedById = null;
        $this->aUserFrom = null;
        $this->aUserTo = null;
        $this->aParentTo = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MessagesTableMap::DEFAULT_STRING_FORMAT);
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
