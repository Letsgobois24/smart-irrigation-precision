from database.mariadb.mariadb_client import createConnection


def createDependency():
    conn = createConnection()
    try:
        yield conn
    finally:
        conn.close()

def getConfiguration(conn):
    with conn.cursor() as cursor:
        # Read a single record
        sql = "SELECT * FROM `configurations` WHERE `id`=1"
        cursor.execute(sql)
        return cursor.fetchone()
    
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
        (event_id, tree_id, node_id, dominant_feature, fault_ratio, severity, created_at, updated_at) 
        VALUES (%s, %s, %s, %s, %s, %s, FROM_UNIXTIME(%s / 1000), FROM_UNIXTIME(%s / 1000))
        """

        values = (
                data['event_id'],
                data['tree_id'],
                data['node_id'],
                data['dominant_feature'],
                data['fault_ratio'],
                data['severity'],
                data['time'],
                data['time']
            )

        cursor.execute(sql, values)

    conn.commit()

def sendNotification(conn, data: list):
    with conn.cursor() as cursor:
        sql = """
        INSERT INTO notifications 
        (title, message, recomendation, source_type, sensor_type, severity, value, threshold, node_id, tree_id, is_active, is_read, created_at, updated_at) 
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)
        """

        values = []
        for item in data:
            values.append((
                item['title'],
                item['message'],
                item['recomendation'],
                item['source_type'],
                item['sensor_type'],
                item['severity'],
                item['value'],
                item['threshold'],
                item.get('node_id'),
                item.get('tree_id'),
                int(item['is_active']),
                int(item['is_read']),
                item['created_at'],
                item['updated_at']
            ))

        cursor.executemany(sql, values)

    conn.commit()