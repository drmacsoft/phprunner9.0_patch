<?php

##foreach @BUILDER.arrConnections as @conn##
    $data = array();
    $data["dbType"] = ##@conn.nDatabaseType##;
    $data["connId"] = "##@conn.strID s##";
    $data["connName"] = "##@conn.strName s##";
    $data["connStringType"] = "##@conn.connStringType s##";
    $data["connectionString"] = "##@conn.strConnectionString s##"; //currently unused

    $this->_connectionsIdByName["##@conn.strName s##"] = "##@conn.strID s##";

    $data["connInfo"] = array();
    $data["ODBCUID"] = "##@conn.strODBCUID s##";
    $data["ODBCPWD"] = "##@conn.strODBCPWD s##";
    $data["leftWrap"] = "##@conn.cLeftWrap s##";
    $data["rightWrap"] = "##@conn.cRightWrap s##";

    $data["DBPath"] = "##@conn.strDBPath s##"; //currently unused	
    $data["useServerMapPath"] = ##@conn.bUseServerMapPath##; //currently unused
    ##if !@conn.strCustomDBConnection##
        $data["connInfo"][0] = "##@conn.strConnectInfo1 s##";
        $data["connInfo"][1] = "##@conn.strConnectInfo2 s##";
        $data["connInfo"][2] = "##@conn.strConnectInfo3 s##";
        $data["connInfo"][3] = "##@conn.strConnectInfo4 s##";
        $data["connInfo"][4] = "##@conn.strConnectInfo5 s##";
        $data["connInfo"][5] = "##@conn.strConnectInfo6 s##"; //currently unused
        $data["connInfo"][6] = "##@conn.strConnectInfo7 s##"; //currently unused
        $data["ODBCString"] = "##@conn.strODBCString##";
    ##else##
        ##MakeCustomDBConnection(@conn)##;
    ##endif##
    // encription set
    $data["EncryptInfo"] = array();
    ##with @BUILDER.m_arrEncryptInfo{@conn.strID} as @eInfo##
        ##if @eInfo.len != 0##
            $data["EncryptInfo"]["mode"] = ##@eInfo.nEncryptMode s##;
            $data["EncryptInfo"]["alg"] = ##@eInfo.nEncryptAlgorithm s##;
            $data["EncryptInfo"]["key"] = "##@eInfo.strEncryptKey s##";
            ##if @conn.nDatabaseType == nDATABASE_MSSQLServer##
                $data["EncryptInfo"]["slqserverkey"] = "##@eInfo.strSQLServerKey s##";
                $data["EncryptInfo"]["slqservercert"] = "##@eInfo.strSQLServerCertificate s##";
            ##endif##
        ##endif##
    ##endwith##

    $connectionsData["##@conn.strID s##"] = $data;
##endfor##