 <?php
 void loop(){
  HTTPClient http;

  //แปลงค่าที่วัดได้เป็นทศนิยม
  project_id = 100001; //รหัสโปรเจ็ค
  val1 = float(oxigen); //ออกซิเจน
  val2 = float(water_temp); //อุณหภูมิน้ำ
  val3 = float(ph) //กรดดด่าง
  val4 = float(salinity) //ความเค็ม
  val5 = float(elec_cond) //การนำไฟฟ้า
  val6 = float(air_temp) //อุณหภูมิอากาศ
  val7 = float(humidity) //ความชื้นสัมพัทธ์

  postData = "p_id=" + project_id + "&ox_val=" + val1 + "&water_temp_val=" + val2 +
            "&ph_val=" + val3 + "&sal_val=" + val4 + "&cond_val=" + val5 + 
            "&air_temp_val=" + val6 + "&hum_val=" + val7;
  http.begin("http://192.168.4.2/db-log-data.php");  //ที่อยู่จัดเก็บไฟล์ php
  http.addHeader("Content-Type", "application/x-www-form-urlencoded");
  int httpCode = http.POST(postData);   //่ส่งข้อมูล
  
  //ทดสอบผลทางหน้าจอ
  //Serial.println("Values are, sendval = " + sendval + " and sendval2 = "+sendval2 );
  
  //เช็คการส่งข้อมูลสำเร็จหรือไม่
  if (httpCode == 200) { Serial.println("Values uploaded successfully."); Serial.println(httpCode);
    String webpage = http.getString();
    Serial.println(webpage + "\n");
  } else {
    Serial.println(httpCode);
    Serial.println("Failed to upload values. \n");
    http.end();
    return;
  }
 }
 delay(10000);
?>