#!/usr/bin/env python
import mysql.connector as mysql
import sys
import json

id_users = sys.argv[1]
level_now = sys.argv[2]
id_histori_tes = sys.argv[3]

db = mysql.connect(
    host = "localhost",
    user = "root",
    passwd = "!!!1Sampai9!!!",
    database = "db_kms"
)

cursor = db.cursor()
query1 = "SELECT * FROM view_master_bab where level="+level_now
cursor.execute(query1)
tblMBab = cursor.fetchall()

def _sum(arr,n):

    # return sum using sum
    # inbuilt sum() function
    return(sum(arr))

rekomendasi = []
for a in tblMBab:
    cursor = db.cursor()
    query5 = "SELECT COUNT(*) FROM view_master_pilihan where id_master_bab="+str(a[0])
    cursor.execute(query5)
    tblMPilihan = cursor.fetchone()

    if tblMPilihan[0] == 0:
        continue

    total_nilai = 0
    absolute_error = []

    query2 = "SELECT nilai FROM view_histori_jawaban where created_by="+id_users+" and id_histori_tes="+id_histori_tes+" and id_master_bab="+str(a[0])
    cursor.execute(query2)   
    viewHJawaban = cursor.fetchall()
    #print(query2)
    for b in viewHJawaban:
        total_nilai = total_nilai+b[0]
        
    nilai_tertinggi = 0
    if int(level_now) == 0:
        query3 = "SELECT nilai FROM view_master_pilihan where nilai=3 and id_master_bab="+str(a[0])
        cursor.execute(query3)
        viewMPilihan = cursor.fetchall()
        for c in viewMPilihan:
            nilai_tertinggi = nilai_tertinggi+c[0]

        nilai_presentase = (total_nilai/nilai_tertinggi)*100
    else:
        query3 = "SELECT nilai FROM view_master_pilihan where nilai=1 and id_master_bab="+str(a[0])
        cursor.execute(query3)
        viewMPilihan = cursor.fetchall()
        for c in viewMPilihan:
            nilai_tertinggi = nilai_tertinggi+c[0]

        nilai_presentase = (total_nilai/nilai_tertinggi)*100
    
    for b in viewHJawaban:
        if int(level_now) == 0:
            nilai_ae = (b[0]/3)-(nilai_presentase/100)
            absolute_error.append(abs(nilai_ae))
        else:
            nilai_ae = (b[0]/1)-(nilai_presentase/100)
            absolute_error.append(abs(nilai_ae))

    n = len(absolute_error)
    total_nilai_ae = _sum(absolute_error, n)
    print(a[0])
    mae = total_nilai_ae/n

    data = {
        'nilai_presentase' : nilai_presentase,
        'mae' : mae,
        'id_master_bab' : a[0]
    }
    rekomendasi.append(data)

#simpan rekomendasi
query4 = "SELECT * FROM tbl_histori_rekomendasi where created_by="+id_users+" and id_histori_tes="+id_histori_tes
cursor.execute(query4)
cek_hrekomendasi = cursor.fetchall()
if len(cek_hrekomendasi) > 0:
    query5 = "DELETE FROM tbl_histori_rekomendasi WHERE created_by="+id_users+" and id_histori_tes="+id_histori_tes
    cursor.execute(query5)
    db.commit()
    for a in rekomendasi:
        query6 = "INSERT INTO tbl_histori_rekomendasi (score, mae, id_master_bab, id_histori_tes, created_by, updated_by) VALUES (%s, %s, %s, %s, %s, %s)"
        values = (a["nilai_presentase"], a["mae"], a["id_master_bab"], id_histori_tes, id_users, id_users)
        cursor.execute(query6, values)
        db.commit()

    print("true")
else:
    for a in rekomendasi:
        query6 = "INSERT INTO tbl_histori_rekomendasi (score, mae, id_master_bab, id_histori_tes, created_by, updated_by) VALUES (%s, %s, %s, %s, %s, %s)"
        values = (a["nilai_presentase"], a["mae"], a["id_master_bab"], id_histori_tes, id_users, id_users)
        cursor.execute(query6, values)
        db.commit()

    print("true")
