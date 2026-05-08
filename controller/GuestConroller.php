<?php
// بنعمل import لملف الموديل عشان نعرف نستخدمه
require_once '../model/GuestModel.php';

class GuestController {
    
    // دي الدالة اللي الشاشة هتنادي عليها
    public function showProfile($id) {
        // 1. بنعمل Object من الموديل (زي الجافا بالظبط)
        $model = new GuestModel();
        
        // 2. بننادي الدالة اللي لسه كاتبينها في الخطوة اللي فاتت ونديها رقم النزيل
        $data = $model->getProfileData($id);
        
        // 3. بنرجع الداتا اللي طلعت عشان نبعتها لصفحة الـ HTML
        return $data;
    }
}
?>