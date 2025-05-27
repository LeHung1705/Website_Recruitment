Tôi sẽ minh họa **luồng hoạt động** của **website quản lý tuyển dụng** từ khi người dùng đăng nhập đến các bước tiếp theo, bao gồm các hành động chính của **Nhà tuyển dụng** và **Ứng viên**. Website sử dụng **HTML, CSS, JavaScript** cho frontend và **Laravel (MVC)** cho backend, với cơ sở dữ liệu gồm 9 bảng: `NGUOIDUNG`, `TINTUYENDUNG`, `HOSOCANHAN`, `DONUNGTUYEN`, `BAIKIEMTRA`, `KETQUABAIKIEMTRA`, `PHONGVAN`, `KETQUAPHONGVAN`, và `THONGBAO`. Tôi sẽ chỉ rõ các bước và ghi chú **truy xuất dữ liệu** từ bảng nào, thuộc tính gì. Thời gian hiện tại là **02:25 PM +07, ngày 23/5/2025**.

---

### Luồng hoạt động của Website Quản lý Tuyển dụng

#### 1. Đăng nhập vào hệ thống
- **Người dùng**: Nhà tuyển dụng hoặc Ứng viên.
- **Các bước**:
  1. Người dùng truy cập trang chủ (`index.blade.php`), nhấn nút "Đăng nhập".
  2. **Frontend (HTML, CSS, JS)**:
     - Chuyển hướng đến `/login` (view `login.blade.php`).
     - Hiển thị form đăng nhập: Tên đăng nhập, Mật khẩu (CSS thiết kế giao diện, JS validate dữ liệu).
  3. **Backend (Laravel MVC)**:
     - **Controller**: `AuthController@showLoginForm` trả về view `login.blade.php`.
     - Người dùng nhập Tên đăng nhập và Mật khẩu, nhấn "Đăng nhập" → POST request `/login`.
     - **Controller**: `AuthController@login`:
       - **Truy xuất dữ liệu**: Từ bảng `NGUOIDUNG`, thuộc tính `ten_dang_nhap` và `mat_khau` để kiểm tra.
       - Nếu khớp, lưu session (`Auth::login()`), kiểm tra thuộc tính `vai_tro` (`nha_tuyen_dung` hoặc `ung_vien`) để chuyển hướng:
         - Nhà tuyển dụng → `/employer/dashboard`.
         - Ứng viên → `/candidate/dashboard`.
       - Nếu không khớp, trả về lỗi (Blade hiển thị: "Tên hoặc mật khẩu không đúng").
- **Kết quả**: Người dùng đăng nhập thành công, chuyển hướng đến dashboard tương ứng.

---

#### 2. Luồng Nhà tuyển dụng: Sau khi đăng nhập
- **Người dùng**: Nhà tuyển dụng (`vai_tro = 'nha_tuyen_dung'`).

##### 2.1 Xem danh sách tin đã đăng
- **Các bước**:
  1. Nhà tuyển dụng vào `/employer/dashboard` (view `employer-dashboard.blade.php`).
  2. **Frontend**:
     - Hiển thị danh sách tin tuyển dụng đã đăng (HTML, CSS thiết kế bảng/list).
  3. **Backend**:
     - **Controller**: `JobController@index`:
       - **Truy xuất dữ liệu**: Từ bảng `TINTUYENDUNG`, thuộc tính `tieu_de`, `nganh_nghe`, `dia_diem`, `luong`, `trang_thai`, `created_at` WHERE `nguoi_dang_id = Auth::id()`.
       - Trả về danh sách tin → Blade render danh sách.
  4. Nhà tuyển dụng nhấn nút "Đăng tin mới" hoặc "Xem ứng viên" cho một tin.

##### 2.2 Đăng tin tuyển dụng
- **Các bước**:
  1. Nhà tuyển dụng nhấn "Đăng tin mới" trên dashboard.
  2. **Frontend**:
     - Chuyển hướng đến `/employer/post-job` (view `post-job.blade.php`).
     - Form hiển thị: Tiêu đề, Mô tả, Ngành nghề, Loại công việc, Địa điểm, Lương (JS validate dữ liệu).
  3. **Backend**:
     - **Controller**: `JobController@showPostForm` trả về view.
     - Submit form → POST `/employer/post-job` → `JobController@store`:
       - Lưu dữ liệu vào bảng `TINTUYENDUNG`:
         - `nguoi_dang_id` = `Auth::id()`.
         - `tieu_de`, `mo_ta`, `nganh_nghe`, `loai_cong_viec`, `dia_diem`, `luong` từ form.
         - `trang_thai` mặc định là `da_phe_duyet`.
       - Trả về thông báo thành công (Blade hiển thị: "Đăng tin thành công").
  4. Nhà tuyển dụng quay lại dashboard, thấy tin mới trong danh sách.

##### 2.3 Xem danh sách ứng viên và gửi lời mời kiểm tra
- **Các bước**:
  1. Nhà tuyển dụng chọn một tin (ví dụ: ID = 1), nhấn "Xem ứng viên".
  2. **Frontend**:
     - Chuyển hướng đến `/employer/jobs/1/applications` (view `job-applications.blade.php`).
     - Hiển thị danh sách ứng viên đã ứng tuyển (HTML, CSS thiết kế bảng).
  3. **Backend**:
     - **Controller**: `ApplicationController@showApplications`:
       - **Truy xuất dữ liệu**:
         - Từ bảng `DONUNGTUYEN`: `ung_vien_id`, `trang_thai` WHERE `tin_tuyen_dung_id = 1`.
         - Join bảng `NGUOIDUNG`: `ho_ten` WHERE `id = ung_vien_id`.
         - Join bảng `HOSOCANHAN`: `hoc_van`, `kinh_nghiem`, `ky_nang` WHERE `nguoi_dung_id = ung_vien_id`.
       - Trả về danh sách → Blade render.
  4. Nhà tuyển dụng chọn ứng viên (ví dụ: ID = 2), nhấn "Tạo bài kiểm tra".
     - Chuyển hướng đến `/employer/tests/create` (view `test-create.blade.php`).
     - Form: Nội dung, Loại bài (JS validate).
     - **Controller**: `TestController@create` → Lưu vào `BAIKIEMTRA`:
       - `nguoi_tao_id` = `Auth::id()`.
       - `noi_dung`, `loai_bai` từ form.
     - Chuyển hướng đến `/employer/tests/1/invite`.
  5. Nhà tuyển dụng gửi lời mời:
     - **Controller**: `TestController@sendInvite`:
       - Lưu thông báo vào `THONGBAO`:
         - `nguoi_nhan_id` = 2 (ứng viên ID).
         - `noi_dung` = "Bạn có lời mời làm bài kiểm tra".
         - `trang_thai` = `chua_doc`.
         - `thoi_gian_gui` = thời gian hiện tại.
       - Blade hiển thị: "Gửi lời mời thành công".

##### 2.4 Đặt lịch phỏng vấn
- **Các bước**:
  1. Nhà tuyển dụng chọn ứng viên từ danh sách, nhấn "Gửi lời mời phỏng vấn".
  2. **Frontend**:
     - Chuyển hướng đến `/employer/interviews/invite` (view `interview-invite.blade.php`).
     - Form: Ngày, Hình thức (JS validate).
  3. **Backend**:
     - **Controller**: `InterviewController@sendInvite`:
       - Lưu vào `PHONGVAN`:
         - `nguoi_to_chuc_id` = `Auth::id()`.
         - `don_ung_tuyen_id` = ID của đơn ứng tuyển.
         - `thoi_gian`, `hinh_thuc` từ form.
       - Lưu thông báo vào `THONGBAO`:
         - `nguoi_nhan_id` = 2 (ứng viên ID).
         - `noi_dung` = "Bạn có lời mời phỏng vấn".
         - `trang_thai` = `chua_doc`.
       - Blade hiển thị: "Gửi lời mời thành công".

---

#### 3. Luồng Ứng viên: Sau khi đăng nhập
- **Người dùng**: Ứng viên (`vai_tro = 'ung_vien'`).

##### 3.1 Tạo/Chỉnh sửa hồ sơ
- **Các bước**:
  1. Ứng viên vào `/candidate/dashboard`, nhấn "Tạo hồ sơ" (nếu chưa có) hoặc "Chỉnh sửa hồ sơ".
  2. **Frontend**:
     - Chuyển hướng đến `/candidate/profile` (view `profile.blade.php`).
     - Form: Học vấn, Kinh nghiệm, Kỹ năng (JS validate).
  3. **Backend**:
     - **Controller**: `ProfileController@show`:
       - **Truy xuất dữ liệu**: Từ bảng `HOSOCANHAN`, `hoc_van`, `kinh_nghiem`, `ky_nang` WHERE `nguoi_dung_id = Auth::id()`.
     - Submit form → `ProfileController@storeOrUpdate`:
       - Lưu vào `HOSOCANHAN`:
         - `nguoi_dung_id` = `Auth::id()`.
         - `hoc_van`, `kinh_nghiem`, `ky_nang` từ form.
       - Blade hiển thị: "Cập nhật hồ sơ thành công".

##### 3.2 Tìm kiếm và ứng tuyển công việc
- **Các bước**:
  1. Ứng viên nhấn "Tìm kiếm việc làm" trên dashboard.
  2. **Frontend**:
     - Chuyển hướng đến `/jobs` (view `jobs.blade.php`).
     - Form tìm kiếm: Ngành nghề, Địa điểm (JS xử lý lọc).
  3. **Backend**:
     - **Controller**: `ApplicationController@showJobs`:
       - **Truy xuất dữ liệu**: Từ bảng `TINTUYENDUNG`, `tieu_de`, `nganh_nghe`, `dia_diem`, `luong` WHERE `trang_thai = 'da_phe_duyet'`.
       - Trả về danh sách → Blade render.
  4. Ứng viên nhấn "Xem chi tiết" (ví dụ: `/jobs/1`):
     - **Controller**: `ApplicationController@showJobDetail`:
       - **Truy xuất dữ liệu**: Từ bảng `TINTUYENDUNG`, `tieu_de`, `mo_ta`, `nganh_nghe`, `loai_cong_viec`, `dia_diem`, `luong` WHERE `id = 1`.
  5. Ứng viên nhấn "Ứng tuyển":
     - **Controller**: `ApplicationController@apply`:
       - Lưu vào `DONUNGTUYEN`:
         - `ung_vien_id` = `Auth::id()`.
         - `tin_tuyen_dung_id` = 1.
         - `trang_thai` = `cho_xu_ly`.
       - Blade hiển thị: "Ứng tuyển thành công".

##### 3.3 Nhận gợi ý công việc
- **Các bước**:
  1. Ứng viên vào `/candidate/suggestions`.
  2. **Backend**:
     - **Controller**: `SuggestionController@show`:
       - **Truy xuất dữ liệu**:
         - Từ bảng `HOSOCANHAN`: `ky_nang`, `hoc_van` WHERE `nguoi_dung_id = Auth::id()`.
         - Từ bảng `TINTUYENDUNG`: `nganh_nghe`, `tieu_de`, `dia_diem` WHERE `trang_thai = 'da_phe_duyet'`.
       - Thuật toán cơ bản: So sánh `ky_nang` và `hoc_van` với `nganh_nghe`.
  3. **Frontend**:
     - View `suggestions.blade.php` hiển thị danh sách gợi ý (HTML, CSS).
     - Ứng viên có thể nhấn "Ứng tuyển" (quay lại luồng ứng tuyển).

##### 3.4 Nhận thông báo và tham gia bài kiểm tra
- **Các bước**:
  1. Ứng viên vào `/candidate/notifications`:
     - **Controller**: `NotificationController@show`:
       - **Truy xuất dữ liệu**: Từ bảng `THONGBAO`, `noi_dung`, `trang_thai`, `thoi_gian_gui` WHERE `nguoi_nhan_id = Auth::id()`.
     - Hiển thị: "Bạn có lời mời làm bài kiểm tra" (Blade render).
  2. Ứng viên nhấn "Tham gia":
     - Chuyển hướng đến `/candidate/tests/1` (view `test.blade.php`).
     - **Controller**: `TestController@showTest`:
       - **Truy xuất dữ liệu**: Từ bảng `BAIKIEMTRA`, `noi_dung`, `loai_bai` WHERE `id = 1`.
     - Form bài kiểm tra hiển thị (HTML, CSS).
  3. Ứng viên làm bài, nhấn "Nộp bài":
     - **Controller**: `TestController@submitTest`:
       - Lưu vào `KETQUABAIKIEMTRA`:
         - `nguoi_lam_id` = `Auth::id()`.
         - `bai_kiem_tra_id` = 1.
         - `diem_so`, `ngay_lam` từ form.
       - Blade hiển thị: "Nộp bài thành công".

##### 3.5 Tham gia phỏng vấn và nhận kết quả
- **Các bước**:
  1. Ứng viên nhận thông báo: "Bạn có lời mời phỏng vấn":
     - **Truy xuất dữ liệu**: Từ bảng `THONGBAO`, `noi_dung`, `thoi_gian_gui` WHERE `nguoi_nhan_id = Auth::id()`.
  2. Ứng viên nhấn "Xác nhận":
     - Chuyển hướng đến `/candidate/interviews/1`:
     - **Controller**: `InterviewController@confirm`:
       - Cập nhật `PHONGVAN` (xác nhận tham gia).
  3. Sau phỏng vấn, Ứng viên nhận kết quả:
     - **Controller**: `InterviewController@showResult`:
       - **Truy xuất dữ liệu**: Từ bảng `KETQUAPHONGVAN`, `diem_so`, `nhan_xet`, `ket_qua` WHERE `phong_van_id = 1`.
     - Blade hiển thị: "Kết quả phỏng vấn: Đậu/Rớt".

---

### 4. Tóm tắt luồng tổng quát
- **Đăng nhập** → Dashboard:
  - **Nhà tuyển dụng**:
    1. Xem danh sách tin (`TINTUYENDUNG`).
    2. Đăng tin mới (`TINTUYENDUNG`).
    3. Xem ứng viên (`DONUNGTUYEN`, `NGUOIDUNG`, `HOSOCANHAN`).
    4. Tạo bài kiểm tra và gửi lời mời (`BAIKIEMTRA`, `THONGBAO`).
    5. Đặt lịch phỏng vấn (`PHONGVAN`, `THONGBAO`).
  - **Ứng viên**:
    1. Tạo/Chỉnh sửa hồ sơ (`HOSOCANHAN`).
    2. Tìm kiếm và ứng tuyển (`TINTUYENDUNG`, `DONUNGTUYEN`).
    3. Nhận gợi ý (`HOSOCANHAN`, `TINTUYENDUNG`).
    4. Nhận thông báo, tham gia bài kiểm tra (`THONGBAO`, `BAIKIEMTRA`, `KETQUABAIKIEMTRA`).
    5. Tham gia phỏng vấn, nhận kết quả (`PHONGVAN`, `KETQUAPHONGVAN`).

---

### 5. Lưu ý
- **Hiệu suất**: Mỗi truy vấn < 2 giây (đáp ứng tiêu chí xử lý 100 ứng viên/ngày).
- **Tối ưu hóa**: Có thể thêm index cho các cột như `nganh_nghe` (`TINTUYENDUNG`) để tăng tốc tìm kiếm.
- Nếu cần minh họa thêm (ví dụ: sơ đồ luồng), hãy cho tôi biết! 🚀
