import time
from database.mariadb.mariadb_client import createConnection

def createDependency():
    conn = createConnection()
    try:
        yield conn
    finally:
        conn.close()

def canSendNotification(conn, tree_id: int, feature: str, severity: str, hours: int = 6):
    with conn.cursor() as cursor:
        sql = """
            SELECT created_at FROM `notifications` 
            WHERE `tree_id`=%s 
                AND `dominant_feature`=%s 
                AND `severity`=%s 
                ORDER BY created_at DESC 
                LIMIT 1
            """
        cursor.execute(sql, (tree_id, feature, severity))
        result = cursor.fetchone()

        if result is None:
            return True

        return (time.time() - hours * 3600) >= result['created_at'].timestamp()

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
        (event_id, tree_id, node_id, dominant_feature, severity, created_at, updated_at) 
        VALUES (%s, %s, %s, %s, %s, FROM_UNIXTIME(%s / 1000), FROM_UNIXTIME(%s / 1000))
        """

        values = (
                data['event_id'],
                data['tree_id'],
                data['node_id'],
                data['dominant_feature'],
                data['severity'],
                data['time'],
                data['time']
            )

        cursor.execute(sql, values)

    conn.commit()