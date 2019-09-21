SELECT 
        RP.core_permissionid AS permissionId,
        
        URPL.id              AS URPL_id, 
        URPL.core_plogicid   AS URPL_logicId,
        PL.name              AS URPL_logicName,
        PL.status            AS URPL_logicStatus,
        
        DPL.id               AS DPL_id, 
        DPL.core_plogicid    AS DPL_logicId,
        PL2.name             AS DPL_logicName,
        PL2.status           AS DPL_logicStatus
    FROM 
        core_user_role AS UR 
    JOIN core_role_permission AS RP 
        ON UR.core_roleid = RP.core_roleid  
    LEFT JOIN 
        core_user_role_permission_plogic AS URPL 
            ON UR.id = URPL.core_user_roleid AND RP.core_permissionid = URPL.core_permissionid
    LEFT JOIN
        core_plogic AS PL
            ON URPL.core_plogicid = PL.id 
    LEFT JOIN
        core_permission_plogic as DPL
            ON RP.core_permissionid = DPL.core_permissionid
    LEFT JOIN
        core_plogic AS PL2
            ON DPL.core_plogicid = PL2.id 
WHERE UR.core_userid = 6