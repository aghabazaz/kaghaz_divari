SELECT 
        UP.core_permissionid AS permissionId,
        UPL.id               AS UPL_id, 
        UPL.core_plogicid    AS UPL_logicId,
        PL.name              AS UPL_logicName,
        PL.status            AS UPL_logicStatus,
        DPL.id               AS DPL_id, 
        DPL.core_plogicid    AS DPL_logicId,
        PL2.name             AS DPL_logicName,
        PL2.status           AS DPL_logicStatus
    FROM 
        core_user_permission AS UP 
    LEFT JOIN 
        core_user_permission_plogic AS UPL 
            ON UP.id = UPL.core_user_permissionid
    LEFT JOIN
        core_plogic AS PL
            ON UPL.core_plogicid = PL.id 
    LEFT JOIN
        core_permission_plogic as DPL
            ON UP.core_permissionid = DPL.core_permissionid
    LEFT JOIN
        core_plogic AS PL2
            ON DPL.core_plogicid = PL2.id 
WHERE UP.core_userid = 4