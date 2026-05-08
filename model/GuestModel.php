<?php
// دي زي الـ import في الجافا.. بنجيب ملف الداتا بيز عشان نستخدمه
require_once '../config/Database.php';

class GuestModel {
    private $db; // متغير هنشيل فيه الاتصال بتاع الداتا بيز

    // الـ Constructor ده بيشتغل أوتوماتيك أول ما نعمل Object من الكلاس
    public function __construct() {
        // هنا بننادي على دالة الـ Singleton اللي لسه عاملينها عشان ناخد الـ Connection
        $this->db = Database::getInstance()->getConnection();
    }

    // ==========================================
    // الدالة رقم 1: جلب بيانات النزيل (View Profile)
    // ==========================================
    public function getProfileData($guestId) {
        // 1. بنكتب أمر الـ SQL وبنحط (?) مكان الرقم عشان الأمان
        // استخدمنا جدول guest وعمود guest_num زي ما زميلتك كاتباهم في الـ SQL
        $sql = "SELECT * FROM guest WHERE guest_num = ?";
        
        // 2. بنجهز الأمر (prepare دي بتحمي السيستم من الـ SQL Injection)
        $stmt = $this->db->prepare($sql);
        
        // 3. بنربط الـ $guestId بعلامة الـ (?) .. حرف הـ "i" معناه إن الرقم Integer
        $stmt->bind_param("i", $guestId);
        
        // 4. بننفذ الأمر
        $stmt->execute();
        
        // 5. بنجيب النتيجة
        $result = $stmt->get_result();
        
        // 6. بنرجع البيانات على شكل مصفوفة (Array) عشان الـ Controller يعرف يقراها
        return $result->fetch_assoc();
    }
}
?>