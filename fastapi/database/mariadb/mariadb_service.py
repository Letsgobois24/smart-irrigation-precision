from database.mariadb.mariadb_client import createConnection

def createDependency():
    conn = createConnection()
    try:
        yield conn
    finally:
        conn.close()
    
def toggleSystem(conn, is_active: bool):
    with conn.cursor() as cursor:
        # Read a single record
        sql = "UPDATE `configurations` SET is_active=%s WHERE `id`=1"
        cursor.execute(sql, (is_active, ))
    conn.commit()

def createNotification(conn, data: dict):
    with conn.cursor() as cursor:
        sql = """
        INSERT INTO notifications 
        (event_id, tree_id, node_id, fault_ratio, dominant_feature, dominant_ratio, severity, created_at, updated_at) 
        VALUES (%s, %s, %s, %s, %s, %s, %s, FROM_UNIXTIME(%s / 1000), FROM_UNIXTIME(%s / 1000))
        """

        values = (
                data['event_id'],
                data['tree_id'],
                data['node_id'],
                data['fault_ratio'],
                data['dominant_feature'],
                data['dominant_ratio'],
                data['severity'],
                data['time'],
                data['time']
            )

        cursor.execute(sql, values)

    conn.commit()