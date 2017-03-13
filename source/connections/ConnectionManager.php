<?php
class ConnectionManager
{
	/**
	 * Cached Connection objects
	 * @type Array
	 */
	protected $cache = array();

	/**
	 * Project connections data
	 * @type Array
	 */
	protected $_connectionsData;

	/**
	 * Project connections data
	 * @type Array
	 */
	protected $_connectionsIdByName = array();

	
	/**
	 * An array storing the correspondence between project
	 * datasource tables names and connections ids
	 * @type Array
	 */	
	protected $_tablesConnectionIds;
	
	
	/**
	 * @constructor
	 */
	function __construct()
	{
		$this->_setConnectionsData();
		$this->_setTablesConnectionIds();
	}
	
	/**
	 * Get connection object by the table name
	 * @param String tName
	 * @return Connection
	 */
	public function byTable( $tName )
	{
		$connId = $this->_tablesConnectionIds[ $tName ];
		if( !$connId )
			return $this->getDefault();
		return $this->byId( $connId );
	}

	/**
	 * Get connection object by the connection name
	 * @param String connName
	 * @return Connection
	 */	
	public function byName( $connName )
	{
		$connId = $this->getIdByName( $connName );
		if( !$connId )
			return $this->getDefault();
		return $this->byId( $connId );
	}
	
	/**
	 * Get connection id by the connection name
	 * @param String connName
	 * @return String
	 */	
	protected function getIdByName( $connName )
	{
		return $this->_connectionsIdByName[ $connName ];
	}
	
	/**
	 * Get connection object by the connection id 
	 * @param String connId
	 * @return Connection
	 */	
	public function byId( $connId )
	{
		if( !isset( $this->cache[ $connId ] ) )
			$this->cache[ $connId ] = $this->getConnection( $connId );

		return $this->cache[ $connId ];
	}
	
	/**
	 * Get the default db connection class
	 * @return Connection
	 */
	public function getDefault()
	{
		return $this->byId( "##@BUILDER.strDefaultConnID s##" );
	}

	/**
	 * Get the users table db connection 
	 * @return Connection
	 */	
	public function getForLogin()
	{
##if @BUILDER.strLoginTableConnectionID.len##
		return $this->byId( "##@BUILDER.strLoginTableConnectionID s##" );
##else##		
		return $this->getDefault();
##endif##
	}
	
	/**
	 * Get the log table db connection 
	 * @return Connection
	 */	
	public function getForAudit()
	{
##if @BUILDER.AuditTrailSettings.strLogTableConnectionID.len##
		return $this->byId( "##@BUILDER.AuditTrailSettings.strLogTableConnectionID s##" );
##else##		
		return $this->getDefault();
##endif##
	}
	
	/**
	 * Get the locking table db connection 
	 * @return Connection
	 */		
	public function getForLocking()
	{
##if @BUILDER.AuditTrailSettings.strLockingTableConnectionID.len##
		return $this->byId( "##@BUILDER.AuditTrailSettings.strLockingTableConnectionID s##" );
##else##		
		return $this->getDefault();
##endif##
	}	
	
	/**
	 * Get the 'ug_groups' table db connection 
	 * @return Connection
	 */	
	public function getForUserGroups()
	{
##if @BUILDER.strUGConnectionID.len##
		return $this->byId( "##@BUILDER.strUGConnectionID s##" );
##else##		
		return $this->getDefault();
##endif##
	}		

	/**
	 * Get the saved searches table db connection 
	 * @return Connection
	 */	
	public function getForSavedSearches()
	{
##if @BUILDER.strSavedSearchesConnectionID.len##
		return $this->byId( "##@BUILDER.strSavedSearchesConnectionID s##" );
##else##		
		return $this->getDefault();
##endif##
	}

	/**
	 * Get the webreports tables db connection 
	 * @return Connection
	 */		
	public function getForWebReports()
	{
##if @BUILDER.strWRConnectionID.len##
		return $this->byId( "##@BUILDER.strWRConnectionID s##" );
##else##		
		return $this->getDefault();
##endif##
	}
	
	/**
	 * @param String connId
	 * @return Connection
	 */
	protected function getConnection( $connId )
	{
		include_once getabspath("connections/Connection.##@ext##");
		
		$data = $this->_connectionsData[ $connId ];	
##if @ext == "asp"##
		if(!$connId || !$data)
			return false;
		include_once getabspath("connections/ConnectionASP.asp");
		return new ConnectionASP( $data );
##else##
		switch( $data["connStringType"] )
		{
			case "mysql":
				if( useMySQLiLib() )
				{
					include_once getabspath("connections/MySQLiConnection.##@ext##");
					return new MySQLiConnection( $data );
				}
				
				include_once getabspath("connections/MySQLConnection.##@ext##");	
				return new MySQLConnection( $data );	

			case "mssql":
			case "compact":
				if( useMSSQLWinConnect() )
				{
					include_once getabspath("connections/MSSQLWinConnection.##@ext##");
					return new MSSQLWinConnection( $data );
				}
				if( isSqlsrvExtLoaded() )
				{
					include_once getabspath("connections/MSSQLSrvConnection.##@ext##");	
					return new MSSQLSrvConnection( $data );
				}
				
				include_once getabspath("connections/MSSQLUnixConnection.##@ext##");
				return new MSSQLUnixConnection( $data );			

			case "msaccess":
			case "odbc":
			case "odbcdsn":
			case "custom":
			case "file":
				if( stripos($data["ODBCString"], 'Provider=') !== false )
				{
					include_once getabspath("connections/ADOConnection.##@ext##");
					return new ADOConnection( $data );
				}
				
				include_once getabspath("connections/ODBCConnection.##@ext##");
				return new ODBCConnection( $data );
			
			case "oracle":
				include_once getabspath("connections/OracleConnection.##@ext##");
				return new OracleConnection( $data );

			case "postgre":
				include_once getabspath("connections/PostgreConnection.##@ext##");
				return new PostgreConnection( $data );

			case "db2":
				include_once getabspath("connections/DB2Connection.##@ext##");
				return new DB2Connection( $data );

			case "informix":
				include_once getabspath("connections/InformixConnection.##@ext##");
				return new InformixConnection( $data );

			case "sqlite":
				include_once getabspath("connections/SQLite3Connection.##@ext##");
				return new SQLite3Connection( $data );
		}
##endif##
	}
	
	/**
	 * Set the data representing the project's 
	 * db connection properties
	 */	 
	protected function _setConnectionsData()
	{
		// content of this function can be modified on demo account
		// variable names $data and $connectionsData are important

		$connectionsData = array();
		include 'ConnectionManagerConfig.php';
		$this->_connectionsData = $connectionsData;
	}
	
	/**
	 * Set the data representing the correspondence between 
	 * the project's table names and db connections
	 */	 
	protected function _setTablesConnectionIds()
	{
		$connectionsIds = array();
##foreach @BUILDER.Tables as @t filter @t.strConnectionID.len##
		$connectionsIds["##@t.strDataSourceTable s##"] = "##@t.strConnectionID s##";
##endfor##
		$this->_tablesConnectionIds = $connectionsIds;
	}
	
	/**
	 * Check if It's possible to add to one table's sql query 
	 * an sql subquery to another table.
	 * Access doesn't support subqueries from the same table as main.
	 * @param String dataSourceTName1
	 * @param String dataSourceTName2
	 * @return Boolean
	 */
	public function checkTablesSubqueriesSupport( $dataSourceTName1, $dataSourceTName2 )
	{
		$connId1 = $this->_tablesConnectionIds[ $dataSourceTName1 ];
		$connId2 = $this->_tablesConnectionIds[ $dataSourceTName2 ];
		
		if( $connId1 != $connId2 )
			return false;

		if( $this->_connectionsData[ $connId1 ]["dbType"] == nDATABASE_Access && $dataSourceTName1 == $dataSourceTName2 )
			return false;
			
		return true;	
	}
	
	/**
	 * Close db connections
	 * @destructor
	 */
	function __desctruct() 
	{
		foreach( $this->cache as $connection )
		{
			$connection->close();
		}
	}
}
?>