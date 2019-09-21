SELECT 
        RP.core_permissionid AS permissionId,
        RPL.id               AS RPL_id, 
        RPL.core_plogicid    AS RPL_logicId,
        PL.name              AS RPL_logicName,
        PL.status            AS RPL_logicStatus,
        DPL.id               AS DPL_id, 
        DPL.core_plogicid    AS DPL_logicId,
        PL2.name             AS DPL_logicName,
        PL2.status           AS DPL_logicStatus
	FROM 
		core_user_role AS UR 
	JOIN core_role_permission AS RP 
		ON UR.core_roleid = RP.core_roleid	
    LEFT JOIN 
        core_role_permission_plogic AS RPL 
            ON RP.id = RPL.core_role_permissionid
    LEFT JOIN
        core_plogic AS PL
            ON RPL.core_plogicid = PL.id 
    LEFT JOIN
        core_permission_plogic as DPL
            ON RP.core_permissionid = DPL.core_permissionid
    LEFT JOIN
        core_plogic AS PL2
            ON DPL.core_plogicid = PL2.id 
WHERE UR.core_userid = 4