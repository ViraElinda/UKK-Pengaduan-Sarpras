<?php
$db=new mysqli('localhost','root','','pengaduan_sarpras');
if($db->connect_error){echo 'DB connect error: '.$db->connect_error; exit(1);} 
echo "Unread counts per user:\n";
$res=$db->query('SELECT id_user, COUNT(*) as unread FROM notif WHERE is_read=0 GROUP BY id_user');
if($res){while($r=$res->fetch_assoc()){ echo 'User '. $r['id_user'] . ': ' . $r['unread'] . "\n"; }}
else{echo "Query failed: " . $db->error . "\n";}

echo "\nRecent notifications:\n";
$rs=$db->query('SELECT * FROM notif ORDER BY created_at DESC LIMIT 50');
if($rs){while($n=$rs->fetch_assoc()){ echo "id={$n['id_notif']} user={$n['id_user']} is_read={$n['is_read']} created_at={$n['created_at']} judul={$n['judul']} link={$n['link']}\n"; }}
else{echo "Query failed: " . $db->error . "\n";}
$db->close();
