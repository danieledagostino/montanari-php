<?php

namespace Montanari\Propel\Base;

use \DateTime;
use \Exception;
use \PDO;
use Montanari\Propel\Drivers as ChildDrivers;
use Montanari\Propel\DriversQuery as ChildDriversQuery;
use Montanari\Propel\Messages as ChildMessages;
use Montanari\Propel\MessagesQuery as ChildMessagesQuery;
use Montanari\Propel\Passengers as ChildPassengers;
use Montanari\Propel\PassengersQuery as ChildPassengersQuery;
use Montanari\Propel\UserSettings as ChildUserSettings;
use Montanari\Propel\UserSettingsQuery as ChildUserSettingsQuery;
use Montanari\Propel\Users as ChildUsers;
use Montanari\Propel\UsersQuery as ChildUsersQuery;
use Montanari\Propel\Map\DriversTableMap;
use Montanari\Propel\Map\MessagesTableMap;
use Montanari\Propel\Map\PassengersTableMap;
use Montanari\Propel\Map\UsersTableMap;
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
 * Base class that represents a row from the 'users' table.
 *
 *
 *
 * @package    propel.generator.Montanari.Propel.Base
 */
abstract class Users implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Montanari\\Propel\\Map\\UsersTableMap';


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
     * @var        int
     */
    protected $id;

    /**
     * The value for the username field.
     *
     * @var        string
     */
    protected $username;

    /**
     * The value for the nome field.
     *
     * @var        string
     */
    protected $nome;

    /**
     * The value for the cognome field.
     *
     * @var        string
     */
    protected $cognome;

    /**
     * The value for the password field.
     *
     * @var        string
     */
    protected $password;

    /**
     * The value for the abitazione field.
     *
     * @var        string
     */
    protected $abitazione;

    /**
     * The value for the autonomia field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $autonomia;

    /**
     * The value for the email field.
     *
     * @var        string
     */
    protected $email;

    /**
     * The value for the id_player_notifiche field.
     *
     * @var        string
     */
    protected $id_player_notifiche;

    /**
     * The value for the insert_date field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $insert_date;

    /**
     * The value for the email_confirm field.
     *
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $email_confirm;

    /**
     * The value for the first_access field.
     *
     * Note: this column has a database default value of: true
     * @var        boolean
     */
    protected $first_access;

    /**
     * The value for the code_confirm field.
     *
     * @var        string
     */
    protected $code_confirm;

    /**
     * @var        ObjectCollection|ChildDrivers[] Collection to store aggregation of ChildDrivers objects.
     */
    protected $collDriverss;
    protected $collDriverssPartial;

    /**
     * @var        ObjectCollection|ChildMessages[] Collection to store aggregation of ChildMessages objects.
     */
    protected $collMessagessRelatedByIdUserFrom;
    protected $collMessagessRelatedByIdUserFromPartial;

    /**
     * @var        ObjectCollection|ChildMessages[] Collection to store aggregation of ChildMessages objects.
     */
    protected $collMessagessRelatedByIdUserTo;
    protected $collMessagessRelatedByIdUserToPartial;

    /**
     * @var        ObjectCollection|ChildPassengers[] Collection to store aggregation of ChildPassengers objects.
     */
    protected $collPassengerss;
    protected $collPassengerssPartial;

    /**
     * @var        ChildUserSettings one-to-one related ChildUserSettings object
     */
    protected $singleUserSettings;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildDrivers[]
     */
    protected $driverssScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMessages[]
     */
    protected $messagessRelatedByIdUserFromScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildMessages[]
     */
    protected $messagessRelatedByIdUserToScheduledForDeletion = null;

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
        $this->autonomia = false;
        $this->email_confirm = false;
        $this->first_access = true;
    }

    /**
     * Initializes internal state of Montanari\Propel\Base\Users object.
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
     * Compares this with another <code>Users</code> instance.  If
     * <code>obj</code> is an instance of <code>Users</code>, delegates to
     * <code>equals(Users)</code>.  Otherwise, returns <code>false</code>.
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
     * @return $this|Users The current object, for fluid interface
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [username] column value.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the [nome] column value.
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Get the [cognome] column value.
     *
     * @return string
     */
    public function getCognome()
    {
        return $this->cognome;
    }

    /**
     * Get the [password] column value.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Get the [abitazione] column value.
     *
     * @return string
     */
    public function getAbitazione()
    {
        return $this->abitazione;
    }

    /**
     * Get the [autonomia] column value.
     *
     * @return boolean
     */
    public function getAutonomia()
    {
        return $this->autonomia;
    }

    /**
     * Get the [autonomia] column value.
     *
     * @return boolean
     */
    public function isAutonomia()
    {
        return $this->getAutonomia();
    }

    /**
     * Get the [email] column value.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the [id_player_notifiche] column value.
     *
     * @return string
     */
    public function getIdPlayerNotifiche()
    {
        return $this->id_player_notifiche;
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
     * Get the [email_confirm] column value.
     *
     * @return boolean
     */
    public function getEmailConfirm()
    {
        return $this->email_confirm;
    }

    /**
     * Get the [email_confirm] column value.
     *
     * @return boolean
     */
    public function isEmailConfirm()
    {
        return $this->getEmailConfirm();
    }

    /**
     * Get the [first_access] column value.
     *
     * @return boolean
     */
    public function getFirstAccess()
    {
        return $this->first_access;
    }

    /**
     * Get the [first_access] column value.
     *
     * @return boolean
     */
    public function isFirstAccess()
    {
        return $this->getFirstAccess();
    }

    /**
     * Get the [code_confirm] column value.
     *
     * @return string
     */
    public function getCodeConfirm()
    {
        return $this->code_confirm;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[UsersTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [username] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setUsername($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->username !== $v) {
            $this->username = $v;
            $this->modifiedColumns[UsersTableMap::COL_USERNAME] = true;
        }

        return $this;
    } // setUsername()

    /**
     * Set the value of [nome] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setNome($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->nome !== $v) {
            $this->nome = $v;
            $this->modifiedColumns[UsersTableMap::COL_NOME] = true;
        }

        return $this;
    } // setNome()

    /**
     * Set the value of [cognome] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setCognome($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->cognome !== $v) {
            $this->cognome = $v;
            $this->modifiedColumns[UsersTableMap::COL_COGNOME] = true;
        }

        return $this;
    } // setCognome()

    /**
     * Set the value of [password] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setPassword($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->password !== $v) {
            $this->password = $v;
            $this->modifiedColumns[UsersTableMap::COL_PASSWORD] = true;
        }

        return $this;
    } // setPassword()

    /**
     * Set the value of [abitazione] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setAbitazione($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->abitazione !== $v) {
            $this->abitazione = $v;
            $this->modifiedColumns[UsersTableMap::COL_ABITAZIONE] = true;
        }

        return $this;
    } // setAbitazione()

    /**
     * Sets the value of the [autonomia] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setAutonomia($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->autonomia !== $v) {
            $this->autonomia = $v;
            $this->modifiedColumns[UsersTableMap::COL_AUTONOMIA] = true;
        }

        return $this;
    } // setAutonomia()

    /**
     * Set the value of [email] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setEmail($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->email !== $v) {
            $this->email = $v;
            $this->modifiedColumns[UsersTableMap::COL_EMAIL] = true;
        }

        return $this;
    } // setEmail()

    /**
     * Set the value of [id_player_notifiche] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setIdPlayerNotifiche($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->id_player_notifiche !== $v) {
            $this->id_player_notifiche = $v;
            $this->modifiedColumns[UsersTableMap::COL_ID_PLAYER_NOTIFICHE] = true;
        }

        return $this;
    } // setIdPlayerNotifiche()

    /**
     * Sets the value of [insert_date] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setInsertDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->insert_date !== null || $dt !== null) {
            if ($this->insert_date === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->insert_date->format("Y-m-d H:i:s.u")) {
                $this->insert_date = $dt === null ? null : clone $dt;
                $this->modifiedColumns[UsersTableMap::COL_INSERT_DATE] = true;
            }
        } // if either are not null

        return $this;
    } // setInsertDate()

    /**
     * Sets the value of the [email_confirm] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setEmailConfirm($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->email_confirm !== $v) {
            $this->email_confirm = $v;
            $this->modifiedColumns[UsersTableMap::COL_EMAIL_CONFIRM] = true;
        }

        return $this;
    } // setEmailConfirm()

    /**
     * Sets the value of the [first_access] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param  boolean|integer|string $v The new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setFirstAccess($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->first_access !== $v) {
            $this->first_access = $v;
            $this->modifiedColumns[UsersTableMap::COL_FIRST_ACCESS] = true;
        }

        return $this;
    } // setFirstAccess()

    /**
     * Set the value of [code_confirm] column.
     *
     * @param string $v new value
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function setCodeConfirm($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->code_confirm !== $v) {
            $this->code_confirm = $v;
            $this->modifiedColumns[UsersTableMap::COL_CODE_CONFIRM] = true;
        }

        return $this;
    } // setCodeConfirm()

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
            if ($this->autonomia !== false) {
                return false;
            }

            if ($this->email_confirm !== false) {
                return false;
            }

            if ($this->first_access !== true) {
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

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : UsersTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : UsersTableMap::translateFieldName('Username', TableMap::TYPE_PHPNAME, $indexType)];
            $this->username = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : UsersTableMap::translateFieldName('Nome', TableMap::TYPE_PHPNAME, $indexType)];
            $this->nome = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : UsersTableMap::translateFieldName('Cognome', TableMap::TYPE_PHPNAME, $indexType)];
            $this->cognome = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : UsersTableMap::translateFieldName('Password', TableMap::TYPE_PHPNAME, $indexType)];
            $this->password = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : UsersTableMap::translateFieldName('Abitazione', TableMap::TYPE_PHPNAME, $indexType)];
            $this->abitazione = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : UsersTableMap::translateFieldName('Autonomia', TableMap::TYPE_PHPNAME, $indexType)];
            $this->autonomia = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : UsersTableMap::translateFieldName('Email', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 8 + $startcol : UsersTableMap::translateFieldName('IdPlayerNotifiche', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id_player_notifiche = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 9 + $startcol : UsersTableMap::translateFieldName('InsertDate', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->insert_date = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 10 + $startcol : UsersTableMap::translateFieldName('EmailConfirm', TableMap::TYPE_PHPNAME, $indexType)];
            $this->email_confirm = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 11 + $startcol : UsersTableMap::translateFieldName('FirstAccess', TableMap::TYPE_PHPNAME, $indexType)];
            $this->first_access = (null !== $col) ? (boolean) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 12 + $startcol : UsersTableMap::translateFieldName('CodeConfirm', TableMap::TYPE_PHPNAME, $indexType)];
            $this->code_confirm = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 13; // 13 = UsersTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Montanari\\Propel\\Users'), 0, $e);
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
            $con = Propel::getServiceContainer()->getReadConnection(UsersTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildUsersQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collDriverss = null;

            $this->collMessagessRelatedByIdUserFrom = null;

            $this->collMessagessRelatedByIdUserTo = null;

            $this->collPassengerss = null;

            $this->singleUserSettings = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Users::setDeleted()
     * @see Users::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildUsersQuery::create()
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
            $con = Propel::getServiceContainer()->getWriteConnection(UsersTableMap::DATABASE_NAME);
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
                UsersTableMap::addInstanceToPool($this);
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

            if ($this->messagessRelatedByIdUserFromScheduledForDeletion !== null) {
                if (!$this->messagessRelatedByIdUserFromScheduledForDeletion->isEmpty()) {
                    \Montanari\Propel\MessagesQuery::create()
                        ->filterByPrimaryKeys($this->messagessRelatedByIdUserFromScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->messagessRelatedByIdUserFromScheduledForDeletion = null;
                }
            }

            if ($this->collMessagessRelatedByIdUserFrom !== null) {
                foreach ($this->collMessagessRelatedByIdUserFrom as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->messagessRelatedByIdUserToScheduledForDeletion !== null) {
                if (!$this->messagessRelatedByIdUserToScheduledForDeletion->isEmpty()) {
                    \Montanari\Propel\MessagesQuery::create()
                        ->filterByPrimaryKeys($this->messagessRelatedByIdUserToScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->messagessRelatedByIdUserToScheduledForDeletion = null;
                }
            }

            if ($this->collMessagessRelatedByIdUserTo !== null) {
                foreach ($this->collMessagessRelatedByIdUserTo as $referrerFK) {
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

            if ($this->singleUserSettings !== null) {
                if (!$this->singleUserSettings->isDeleted() && ($this->singleUserSettings->isNew() || $this->singleUserSettings->isModified())) {
                    $affectedRows += $this->singleUserSettings->save($con);
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

        $this->modifiedColumns[UsersTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . UsersTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(UsersTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERNAME)) {
            $modifiedColumns[':p' . $index++]  = 'username';
        }
        if ($this->isColumnModified(UsersTableMap::COL_NOME)) {
            $modifiedColumns[':p' . $index++]  = 'nome';
        }
        if ($this->isColumnModified(UsersTableMap::COL_COGNOME)) {
            $modifiedColumns[':p' . $index++]  = 'cognome';
        }
        if ($this->isColumnModified(UsersTableMap::COL_PASSWORD)) {
            $modifiedColumns[':p' . $index++]  = 'password';
        }
        if ($this->isColumnModified(UsersTableMap::COL_ABITAZIONE)) {
            $modifiedColumns[':p' . $index++]  = 'abitazione';
        }
        if ($this->isColumnModified(UsersTableMap::COL_AUTONOMIA)) {
            $modifiedColumns[':p' . $index++]  = 'autonomia';
        }
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL)) {
            $modifiedColumns[':p' . $index++]  = 'email';
        }
        if ($this->isColumnModified(UsersTableMap::COL_ID_PLAYER_NOTIFICHE)) {
            $modifiedColumns[':p' . $index++]  = 'id_player_notifiche';
        }
        if ($this->isColumnModified(UsersTableMap::COL_INSERT_DATE)) {
            $modifiedColumns[':p' . $index++]  = 'insert_date';
        }
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL_CONFIRM)) {
            $modifiedColumns[':p' . $index++]  = 'email_confirm';
        }
        if ($this->isColumnModified(UsersTableMap::COL_FIRST_ACCESS)) {
            $modifiedColumns[':p' . $index++]  = 'first_access';
        }
        if ($this->isColumnModified(UsersTableMap::COL_CODE_CONFIRM)) {
            $modifiedColumns[':p' . $index++]  = 'code_confirm';
        }

        $sql = sprintf(
            'INSERT INTO users (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'username':
                        $stmt->bindValue($identifier, $this->username, PDO::PARAM_STR);
                        break;
                    case 'nome':
                        $stmt->bindValue($identifier, $this->nome, PDO::PARAM_STR);
                        break;
                    case 'cognome':
                        $stmt->bindValue($identifier, $this->cognome, PDO::PARAM_STR);
                        break;
                    case 'password':
                        $stmt->bindValue($identifier, $this->password, PDO::PARAM_STR);
                        break;
                    case 'abitazione':
                        $stmt->bindValue($identifier, $this->abitazione, PDO::PARAM_STR);
                        break;
                    case 'autonomia':
                        $stmt->bindValue($identifier, (int) $this->autonomia, PDO::PARAM_INT);
                        break;
                    case 'email':
                        $stmt->bindValue($identifier, $this->email, PDO::PARAM_STR);
                        break;
                    case 'id_player_notifiche':
                        $stmt->bindValue($identifier, $this->id_player_notifiche, PDO::PARAM_STR);
                        break;
                    case 'insert_date':
                        $stmt->bindValue($identifier, $this->insert_date ? $this->insert_date->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'email_confirm':
                        $stmt->bindValue($identifier, (int) $this->email_confirm, PDO::PARAM_INT);
                        break;
                    case 'first_access':
                        $stmt->bindValue($identifier, (int) $this->first_access, PDO::PARAM_INT);
                        break;
                    case 'code_confirm':
                        $stmt->bindValue($identifier, $this->code_confirm, PDO::PARAM_STR);
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
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
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
                return $this->getUsername();
                break;
            case 2:
                return $this->getNome();
                break;
            case 3:
                return $this->getCognome();
                break;
            case 4:
                return $this->getPassword();
                break;
            case 5:
                return $this->getAbitazione();
                break;
            case 6:
                return $this->getAutonomia();
                break;
            case 7:
                return $this->getEmail();
                break;
            case 8:
                return $this->getIdPlayerNotifiche();
                break;
            case 9:
                return $this->getInsertDate();
                break;
            case 10:
                return $this->getEmailConfirm();
                break;
            case 11:
                return $this->getFirstAccess();
                break;
            case 12:
                return $this->getCodeConfirm();
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

        if (isset($alreadyDumpedObjects['Users'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Users'][$this->hashCode()] = true;
        $keys = UsersTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getUsername(),
            $keys[2] => $this->getNome(),
            $keys[3] => $this->getCognome(),
            $keys[4] => $this->getPassword(),
            $keys[5] => $this->getAbitazione(),
            $keys[6] => $this->getAutonomia(),
            $keys[7] => $this->getEmail(),
            $keys[8] => $this->getIdPlayerNotifiche(),
            $keys[9] => $this->getInsertDate(),
            $keys[10] => $this->getEmailConfirm(),
            $keys[11] => $this->getFirstAccess(),
            $keys[12] => $this->getCodeConfirm(),
        );
        if ($result[$keys[9]] instanceof \DateTimeInterface) {
            $result[$keys[9]] = $result[$keys[9]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
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
            if (null !== $this->collMessagessRelatedByIdUserFrom) {

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

                $result[$key] = $this->collMessagessRelatedByIdUserFrom->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMessagessRelatedByIdUserTo) {

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

                $result[$key] = $this->collMessagessRelatedByIdUserTo->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
            if (null !== $this->singleUserSettings) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'userSettings';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'user_settings';
                        break;
                    default:
                        $key = 'UserSettings';
                }

                $result[$key] = $this->singleUserSettings->toArray($keyType, $includeLazyLoadColumns, $alreadyDumpedObjects, true);
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
     * @return $this|\Montanari\Propel\Users
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = UsersTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Montanari\Propel\Users
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setUsername($value);
                break;
            case 2:
                $this->setNome($value);
                break;
            case 3:
                $this->setCognome($value);
                break;
            case 4:
                $this->setPassword($value);
                break;
            case 5:
                $this->setAbitazione($value);
                break;
            case 6:
                $this->setAutonomia($value);
                break;
            case 7:
                $this->setEmail($value);
                break;
            case 8:
                $this->setIdPlayerNotifiche($value);
                break;
            case 9:
                $this->setInsertDate($value);
                break;
            case 10:
                $this->setEmailConfirm($value);
                break;
            case 11:
                $this->setFirstAccess($value);
                break;
            case 12:
                $this->setCodeConfirm($value);
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
        $keys = UsersTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setUsername($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setNome($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setCognome($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setPassword($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setAbitazione($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setAutonomia($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setEmail($arr[$keys[7]]);
        }
        if (array_key_exists($keys[8], $arr)) {
            $this->setIdPlayerNotifiche($arr[$keys[8]]);
        }
        if (array_key_exists($keys[9], $arr)) {
            $this->setInsertDate($arr[$keys[9]]);
        }
        if (array_key_exists($keys[10], $arr)) {
            $this->setEmailConfirm($arr[$keys[10]]);
        }
        if (array_key_exists($keys[11], $arr)) {
            $this->setFirstAccess($arr[$keys[11]]);
        }
        if (array_key_exists($keys[12], $arr)) {
            $this->setCodeConfirm($arr[$keys[12]]);
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
     * @return $this|\Montanari\Propel\Users The current object, for fluid interface
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
        $criteria = new Criteria(UsersTableMap::DATABASE_NAME);

        if ($this->isColumnModified(UsersTableMap::COL_ID)) {
            $criteria->add(UsersTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(UsersTableMap::COL_USERNAME)) {
            $criteria->add(UsersTableMap::COL_USERNAME, $this->username);
        }
        if ($this->isColumnModified(UsersTableMap::COL_NOME)) {
            $criteria->add(UsersTableMap::COL_NOME, $this->nome);
        }
        if ($this->isColumnModified(UsersTableMap::COL_COGNOME)) {
            $criteria->add(UsersTableMap::COL_COGNOME, $this->cognome);
        }
        if ($this->isColumnModified(UsersTableMap::COL_PASSWORD)) {
            $criteria->add(UsersTableMap::COL_PASSWORD, $this->password);
        }
        if ($this->isColumnModified(UsersTableMap::COL_ABITAZIONE)) {
            $criteria->add(UsersTableMap::COL_ABITAZIONE, $this->abitazione);
        }
        if ($this->isColumnModified(UsersTableMap::COL_AUTONOMIA)) {
            $criteria->add(UsersTableMap::COL_AUTONOMIA, $this->autonomia);
        }
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL)) {
            $criteria->add(UsersTableMap::COL_EMAIL, $this->email);
        }
        if ($this->isColumnModified(UsersTableMap::COL_ID_PLAYER_NOTIFICHE)) {
            $criteria->add(UsersTableMap::COL_ID_PLAYER_NOTIFICHE, $this->id_player_notifiche);
        }
        if ($this->isColumnModified(UsersTableMap::COL_INSERT_DATE)) {
            $criteria->add(UsersTableMap::COL_INSERT_DATE, $this->insert_date);
        }
        if ($this->isColumnModified(UsersTableMap::COL_EMAIL_CONFIRM)) {
            $criteria->add(UsersTableMap::COL_EMAIL_CONFIRM, $this->email_confirm);
        }
        if ($this->isColumnModified(UsersTableMap::COL_FIRST_ACCESS)) {
            $criteria->add(UsersTableMap::COL_FIRST_ACCESS, $this->first_access);
        }
        if ($this->isColumnModified(UsersTableMap::COL_CODE_CONFIRM)) {
            $criteria->add(UsersTableMap::COL_CODE_CONFIRM, $this->code_confirm);
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
        $criteria = ChildUsersQuery::create();
        $criteria->add(UsersTableMap::COL_ID, $this->id);

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
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
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
     * @param      object $copyObj An object of \Montanari\Propel\Users (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setUsername($this->getUsername());
        $copyObj->setNome($this->getNome());
        $copyObj->setCognome($this->getCognome());
        $copyObj->setPassword($this->getPassword());
        $copyObj->setAbitazione($this->getAbitazione());
        $copyObj->setAutonomia($this->getAutonomia());
        $copyObj->setEmail($this->getEmail());
        $copyObj->setIdPlayerNotifiche($this->getIdPlayerNotifiche());
        $copyObj->setInsertDate($this->getInsertDate());
        $copyObj->setEmailConfirm($this->getEmailConfirm());
        $copyObj->setFirstAccess($this->getFirstAccess());
        $copyObj->setCodeConfirm($this->getCodeConfirm());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getDriverss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDrivers($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMessagessRelatedByIdUserFrom() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMessagesRelatedByIdUserFrom($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMessagessRelatedByIdUserTo() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMessagesRelatedByIdUserTo($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPassengerss() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPassengers($relObj->copy($deepCopy));
                }
            }

            $relObj = $this->getUserSettings();
            if ($relObj) {
                $copyObj->setUserSettings($relObj->copy($deepCopy));
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
     * @return \Montanari\Propel\Users Clone of current object.
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
        if ('Drivers' == $relationName) {
            $this->initDriverss();
            return;
        }
        if ('MessagesRelatedByIdUserFrom' == $relationName) {
            $this->initMessagessRelatedByIdUserFrom();
            return;
        }
        if ('MessagesRelatedByIdUserTo' == $relationName) {
            $this->initMessagessRelatedByIdUserTo();
            return;
        }
        if ('Passengers' == $relationName) {
            $this->initPassengerss();
            return;
        }
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
     * If this ChildUsers is new, it will return
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
                    ->filterByUsers($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setDriverss(Collection $driverss, ConnectionInterface $con = null)
    {
        /** @var ChildDrivers[] $driverssToDelete */
        $driverssToDelete = $this->getDriverss(new Criteria(), $con)->diff($driverss);


        $this->driverssScheduledForDeletion = $driverssToDelete;

        foreach ($driverssToDelete as $driversRemoved) {
            $driversRemoved->setUsers(null);
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
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collDriverss);
    }

    /**
     * Method called to associate a ChildDrivers object to this object
     * through the ChildDrivers foreign key attribute.
     *
     * @param  ChildDrivers $l ChildDrivers
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
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
        $drivers->setUsers($this);
    }

    /**
     * @param  ChildDrivers $drivers The ChildDrivers object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $drivers->setUsers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Driverss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildDrivers[] List of ChildDrivers objects
     */
    public function getDriverssJoinEvents(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildDriversQuery::create(null, $criteria);
        $query->joinWith('Events', $joinBehavior);

        return $this->getDriverss($query, $con);
    }

    /**
     * Clears out the collMessagessRelatedByIdUserFrom collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMessagessRelatedByIdUserFrom()
     */
    public function clearMessagessRelatedByIdUserFrom()
    {
        $this->collMessagessRelatedByIdUserFrom = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMessagessRelatedByIdUserFrom collection loaded partially.
     */
    public function resetPartialMessagessRelatedByIdUserFrom($v = true)
    {
        $this->collMessagessRelatedByIdUserFromPartial = $v;
    }

    /**
     * Initializes the collMessagessRelatedByIdUserFrom collection.
     *
     * By default this just sets the collMessagessRelatedByIdUserFrom collection to an empty array (like clearcollMessagessRelatedByIdUserFrom());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMessagessRelatedByIdUserFrom($overrideExisting = true)
    {
        if (null !== $this->collMessagessRelatedByIdUserFrom && !$overrideExisting) {
            return;
        }

        $collectionClassName = MessagesTableMap::getTableMap()->getCollectionClassName();

        $this->collMessagessRelatedByIdUserFrom = new $collectionClassName;
        $this->collMessagessRelatedByIdUserFrom->setModel('\Montanari\Propel\Messages');
    }

    /**
     * Gets an array of ChildMessages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     * @throws PropelException
     */
    public function getMessagessRelatedByIdUserFrom(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMessagessRelatedByIdUserFromPartial && !$this->isNew();
        if (null === $this->collMessagessRelatedByIdUserFrom || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMessagessRelatedByIdUserFrom) {
                // return empty collection
                $this->initMessagessRelatedByIdUserFrom();
            } else {
                $collMessagessRelatedByIdUserFrom = ChildMessagesQuery::create(null, $criteria)
                    ->filterByUserFrom($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMessagessRelatedByIdUserFromPartial && count($collMessagessRelatedByIdUserFrom)) {
                        $this->initMessagessRelatedByIdUserFrom(false);

                        foreach ($collMessagessRelatedByIdUserFrom as $obj) {
                            if (false == $this->collMessagessRelatedByIdUserFrom->contains($obj)) {
                                $this->collMessagessRelatedByIdUserFrom->append($obj);
                            }
                        }

                        $this->collMessagessRelatedByIdUserFromPartial = true;
                    }

                    return $collMessagessRelatedByIdUserFrom;
                }

                if ($partial && $this->collMessagessRelatedByIdUserFrom) {
                    foreach ($this->collMessagessRelatedByIdUserFrom as $obj) {
                        if ($obj->isNew()) {
                            $collMessagessRelatedByIdUserFrom[] = $obj;
                        }
                    }
                }

                $this->collMessagessRelatedByIdUserFrom = $collMessagessRelatedByIdUserFrom;
                $this->collMessagessRelatedByIdUserFromPartial = false;
            }
        }

        return $this->collMessagessRelatedByIdUserFrom;
    }

    /**
     * Sets a collection of ChildMessages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $messagessRelatedByIdUserFrom A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setMessagessRelatedByIdUserFrom(Collection $messagessRelatedByIdUserFrom, ConnectionInterface $con = null)
    {
        /** @var ChildMessages[] $messagessRelatedByIdUserFromToDelete */
        $messagessRelatedByIdUserFromToDelete = $this->getMessagessRelatedByIdUserFrom(new Criteria(), $con)->diff($messagessRelatedByIdUserFrom);


        $this->messagessRelatedByIdUserFromScheduledForDeletion = $messagessRelatedByIdUserFromToDelete;

        foreach ($messagessRelatedByIdUserFromToDelete as $messagesRelatedByIdUserFromRemoved) {
            $messagesRelatedByIdUserFromRemoved->setUserFrom(null);
        }

        $this->collMessagessRelatedByIdUserFrom = null;
        foreach ($messagessRelatedByIdUserFrom as $messagesRelatedByIdUserFrom) {
            $this->addMessagesRelatedByIdUserFrom($messagesRelatedByIdUserFrom);
        }

        $this->collMessagessRelatedByIdUserFrom = $messagessRelatedByIdUserFrom;
        $this->collMessagessRelatedByIdUserFromPartial = false;

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
    public function countMessagessRelatedByIdUserFrom(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMessagessRelatedByIdUserFromPartial && !$this->isNew();
        if (null === $this->collMessagessRelatedByIdUserFrom || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMessagessRelatedByIdUserFrom) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMessagessRelatedByIdUserFrom());
            }

            $query = ChildMessagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserFrom($this)
                ->count($con);
        }

        return count($this->collMessagessRelatedByIdUserFrom);
    }

    /**
     * Method called to associate a ChildMessages object to this object
     * through the ChildMessages foreign key attribute.
     *
     * @param  ChildMessages $l ChildMessages
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function addMessagesRelatedByIdUserFrom(ChildMessages $l)
    {
        if ($this->collMessagessRelatedByIdUserFrom === null) {
            $this->initMessagessRelatedByIdUserFrom();
            $this->collMessagessRelatedByIdUserFromPartial = true;
        }

        if (!$this->collMessagessRelatedByIdUserFrom->contains($l)) {
            $this->doAddMessagesRelatedByIdUserFrom($l);

            if ($this->messagessRelatedByIdUserFromScheduledForDeletion and $this->messagessRelatedByIdUserFromScheduledForDeletion->contains($l)) {
                $this->messagessRelatedByIdUserFromScheduledForDeletion->remove($this->messagessRelatedByIdUserFromScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMessages $messagesRelatedByIdUserFrom The ChildMessages object to add.
     */
    protected function doAddMessagesRelatedByIdUserFrom(ChildMessages $messagesRelatedByIdUserFrom)
    {
        $this->collMessagessRelatedByIdUserFrom[]= $messagesRelatedByIdUserFrom;
        $messagesRelatedByIdUserFrom->setUserFrom($this);
    }

    /**
     * @param  ChildMessages $messagesRelatedByIdUserFrom The ChildMessages object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeMessagesRelatedByIdUserFrom(ChildMessages $messagesRelatedByIdUserFrom)
    {
        if ($this->getMessagessRelatedByIdUserFrom()->contains($messagesRelatedByIdUserFrom)) {
            $pos = $this->collMessagessRelatedByIdUserFrom->search($messagesRelatedByIdUserFrom);
            $this->collMessagessRelatedByIdUserFrom->remove($pos);
            if (null === $this->messagessRelatedByIdUserFromScheduledForDeletion) {
                $this->messagessRelatedByIdUserFromScheduledForDeletion = clone $this->collMessagessRelatedByIdUserFrom;
                $this->messagessRelatedByIdUserFromScheduledForDeletion->clear();
            }
            $this->messagessRelatedByIdUserFromScheduledForDeletion[]= clone $messagesRelatedByIdUserFrom;
            $messagesRelatedByIdUserFrom->setUserFrom(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related MessagessRelatedByIdUserFrom from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     */
    public function getMessagessRelatedByIdUserFromJoinParentTo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMessagesQuery::create(null, $criteria);
        $query->joinWith('ParentTo', $joinBehavior);

        return $this->getMessagessRelatedByIdUserFrom($query, $con);
    }

    /**
     * Clears out the collMessagessRelatedByIdUserTo collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addMessagessRelatedByIdUserTo()
     */
    public function clearMessagessRelatedByIdUserTo()
    {
        $this->collMessagessRelatedByIdUserTo = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collMessagessRelatedByIdUserTo collection loaded partially.
     */
    public function resetPartialMessagessRelatedByIdUserTo($v = true)
    {
        $this->collMessagessRelatedByIdUserToPartial = $v;
    }

    /**
     * Initializes the collMessagessRelatedByIdUserTo collection.
     *
     * By default this just sets the collMessagessRelatedByIdUserTo collection to an empty array (like clearcollMessagessRelatedByIdUserTo());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMessagessRelatedByIdUserTo($overrideExisting = true)
    {
        if (null !== $this->collMessagessRelatedByIdUserTo && !$overrideExisting) {
            return;
        }

        $collectionClassName = MessagesTableMap::getTableMap()->getCollectionClassName();

        $this->collMessagessRelatedByIdUserTo = new $collectionClassName;
        $this->collMessagessRelatedByIdUserTo->setModel('\Montanari\Propel\Messages');
    }

    /**
     * Gets an array of ChildMessages objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildUsers is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     * @throws PropelException
     */
    public function getMessagessRelatedByIdUserTo(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collMessagessRelatedByIdUserToPartial && !$this->isNew();
        if (null === $this->collMessagessRelatedByIdUserTo || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMessagessRelatedByIdUserTo) {
                // return empty collection
                $this->initMessagessRelatedByIdUserTo();
            } else {
                $collMessagessRelatedByIdUserTo = ChildMessagesQuery::create(null, $criteria)
                    ->filterByUserTo($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collMessagessRelatedByIdUserToPartial && count($collMessagessRelatedByIdUserTo)) {
                        $this->initMessagessRelatedByIdUserTo(false);

                        foreach ($collMessagessRelatedByIdUserTo as $obj) {
                            if (false == $this->collMessagessRelatedByIdUserTo->contains($obj)) {
                                $this->collMessagessRelatedByIdUserTo->append($obj);
                            }
                        }

                        $this->collMessagessRelatedByIdUserToPartial = true;
                    }

                    return $collMessagessRelatedByIdUserTo;
                }

                if ($partial && $this->collMessagessRelatedByIdUserTo) {
                    foreach ($this->collMessagessRelatedByIdUserTo as $obj) {
                        if ($obj->isNew()) {
                            $collMessagessRelatedByIdUserTo[] = $obj;
                        }
                    }
                }

                $this->collMessagessRelatedByIdUserTo = $collMessagessRelatedByIdUserTo;
                $this->collMessagessRelatedByIdUserToPartial = false;
            }
        }

        return $this->collMessagessRelatedByIdUserTo;
    }

    /**
     * Sets a collection of ChildMessages objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $messagessRelatedByIdUserTo A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setMessagessRelatedByIdUserTo(Collection $messagessRelatedByIdUserTo, ConnectionInterface $con = null)
    {
        /** @var ChildMessages[] $messagessRelatedByIdUserToToDelete */
        $messagessRelatedByIdUserToToDelete = $this->getMessagessRelatedByIdUserTo(new Criteria(), $con)->diff($messagessRelatedByIdUserTo);


        $this->messagessRelatedByIdUserToScheduledForDeletion = $messagessRelatedByIdUserToToDelete;

        foreach ($messagessRelatedByIdUserToToDelete as $messagesRelatedByIdUserToRemoved) {
            $messagesRelatedByIdUserToRemoved->setUserTo(null);
        }

        $this->collMessagessRelatedByIdUserTo = null;
        foreach ($messagessRelatedByIdUserTo as $messagesRelatedByIdUserTo) {
            $this->addMessagesRelatedByIdUserTo($messagesRelatedByIdUserTo);
        }

        $this->collMessagessRelatedByIdUserTo = $messagessRelatedByIdUserTo;
        $this->collMessagessRelatedByIdUserToPartial = false;

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
    public function countMessagessRelatedByIdUserTo(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collMessagessRelatedByIdUserToPartial && !$this->isNew();
        if (null === $this->collMessagessRelatedByIdUserTo || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMessagessRelatedByIdUserTo) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getMessagessRelatedByIdUserTo());
            }

            $query = ChildMessagesQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByUserTo($this)
                ->count($con);
        }

        return count($this->collMessagessRelatedByIdUserTo);
    }

    /**
     * Method called to associate a ChildMessages object to this object
     * through the ChildMessages foreign key attribute.
     *
     * @param  ChildMessages $l ChildMessages
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     */
    public function addMessagesRelatedByIdUserTo(ChildMessages $l)
    {
        if ($this->collMessagessRelatedByIdUserTo === null) {
            $this->initMessagessRelatedByIdUserTo();
            $this->collMessagessRelatedByIdUserToPartial = true;
        }

        if (!$this->collMessagessRelatedByIdUserTo->contains($l)) {
            $this->doAddMessagesRelatedByIdUserTo($l);

            if ($this->messagessRelatedByIdUserToScheduledForDeletion and $this->messagessRelatedByIdUserToScheduledForDeletion->contains($l)) {
                $this->messagessRelatedByIdUserToScheduledForDeletion->remove($this->messagessRelatedByIdUserToScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildMessages $messagesRelatedByIdUserTo The ChildMessages object to add.
     */
    protected function doAddMessagesRelatedByIdUserTo(ChildMessages $messagesRelatedByIdUserTo)
    {
        $this->collMessagessRelatedByIdUserTo[]= $messagesRelatedByIdUserTo;
        $messagesRelatedByIdUserTo->setUserTo($this);
    }

    /**
     * @param  ChildMessages $messagesRelatedByIdUserTo The ChildMessages object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function removeMessagesRelatedByIdUserTo(ChildMessages $messagesRelatedByIdUserTo)
    {
        if ($this->getMessagessRelatedByIdUserTo()->contains($messagesRelatedByIdUserTo)) {
            $pos = $this->collMessagessRelatedByIdUserTo->search($messagesRelatedByIdUserTo);
            $this->collMessagessRelatedByIdUserTo->remove($pos);
            if (null === $this->messagessRelatedByIdUserToScheduledForDeletion) {
                $this->messagessRelatedByIdUserToScheduledForDeletion = clone $this->collMessagessRelatedByIdUserTo;
                $this->messagessRelatedByIdUserToScheduledForDeletion->clear();
            }
            $this->messagessRelatedByIdUserToScheduledForDeletion[]= clone $messagesRelatedByIdUserTo;
            $messagesRelatedByIdUserTo->setUserTo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related MessagessRelatedByIdUserTo from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildMessages[] List of ChildMessages objects
     */
    public function getMessagessRelatedByIdUserToJoinParentTo(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildMessagesQuery::create(null, $criteria);
        $query->joinWith('ParentTo', $joinBehavior);

        return $this->getMessagessRelatedByIdUserTo($query, $con);
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
     * If this ChildUsers is new, it will return
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
                    ->filterByUsers($this)
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
     * @return $this|ChildUsers The current object (for fluent API support)
     */
    public function setPassengerss(Collection $passengerss, ConnectionInterface $con = null)
    {
        /** @var ChildPassengers[] $passengerssToDelete */
        $passengerssToDelete = $this->getPassengerss(new Criteria(), $con)->diff($passengerss);


        $this->passengerssScheduledForDeletion = $passengerssToDelete;

        foreach ($passengerssToDelete as $passengersRemoved) {
            $passengersRemoved->setUsers(null);
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
                ->filterByUsers($this)
                ->count($con);
        }

        return count($this->collPassengerss);
    }

    /**
     * Method called to associate a ChildPassengers object to this object
     * through the ChildPassengers foreign key attribute.
     *
     * @param  ChildPassengers $l ChildPassengers
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
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
        $passengers->setUsers($this);
    }

    /**
     * @param  ChildPassengers $passengers The ChildPassengers object to remove.
     * @return $this|ChildUsers The current object (for fluent API support)
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
            $passengers->setUsers(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Users is new, it will return
     * an empty collection; or if this Users has previously
     * been saved, it will retrieve related Passengerss from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Users.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPassengers[] List of ChildPassengers objects
     */
    public function getPassengerssJoinEvents(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPassengersQuery::create(null, $criteria);
        $query->joinWith('Events', $joinBehavior);

        return $this->getPassengerss($query, $con);
    }

    /**
     * Gets a single ChildUserSettings object, which is related to this object by a one-to-one relationship.
     *
     * @param  ConnectionInterface $con optional connection object
     * @return ChildUserSettings
     * @throws PropelException
     */
    public function getUserSettings(ConnectionInterface $con = null)
    {

        if ($this->singleUserSettings === null && !$this->isNew()) {
            $this->singleUserSettings = ChildUserSettingsQuery::create()->findPk($this->getPrimaryKey(), $con);
        }

        return $this->singleUserSettings;
    }

    /**
     * Sets a single ChildUserSettings object as related to this object by a one-to-one relationship.
     *
     * @param  ChildUserSettings $v ChildUserSettings
     * @return $this|\Montanari\Propel\Users The current object (for fluent API support)
     * @throws PropelException
     */
    public function setUserSettings(ChildUserSettings $v = null)
    {
        $this->singleUserSettings = $v;

        // Make sure that that the passed-in ChildUserSettings isn't already associated with this object
        if ($v !== null && $v->getUsers(null, false) === null) {
            $v->setUsers($this);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->username = null;
        $this->nome = null;
        $this->cognome = null;
        $this->password = null;
        $this->abitazione = null;
        $this->autonomia = null;
        $this->email = null;
        $this->id_player_notifiche = null;
        $this->insert_date = null;
        $this->email_confirm = null;
        $this->first_access = null;
        $this->code_confirm = null;
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
            if ($this->collDriverss) {
                foreach ($this->collDriverss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMessagessRelatedByIdUserFrom) {
                foreach ($this->collMessagessRelatedByIdUserFrom as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMessagessRelatedByIdUserTo) {
                foreach ($this->collMessagessRelatedByIdUserTo as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPassengerss) {
                foreach ($this->collPassengerss as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->singleUserSettings) {
                $this->singleUserSettings->clearAllReferences($deep);
            }
        } // if ($deep)

        $this->collDriverss = null;
        $this->collMessagessRelatedByIdUserFrom = null;
        $this->collMessagessRelatedByIdUserTo = null;
        $this->collPassengerss = null;
        $this->singleUserSettings = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(UsersTableMap::DEFAULT_STRING_FORMAT);
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
