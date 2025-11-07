<?php include $_SERVER['DOCUMENT_ROOT'] . '/vocabulary/includes/header.php';?>
<!-- MENU CHÍNH -->
<div class="menu" style="font-size: 24px;">
    <ul>
        <h3><?= $_SESSION['user']['username']; ?></h3>
        <li><a href="/vocabulary/form_create_new_word.php">Tạo từ mới</a></li>
        <li><a href="/vocabulary/form_word.php">Từ vựng</a></li>
        <li><a href="/vocabulary/form_read_word.php">Đọc từ</a></li>
        <li><a href="/vocabulary/form_reading.php">Đọc</a></li>
        <li><a href="/vocabulary/form_speak_word.php">Nói từ</a></li>
        <li><a href="/vocabulary/form_speaking.php">Nói</a></li>
        <li><a href="/vocabulary/library_word.php">Thư viện từ</a></li>
        <li><a href="javascript:void(0)" onclick="openSetting()">Cài đặt</a></li>
    </ul>
</div>

<!-- NÚT CÀI ĐẶT NỔI -->
<button id="openSettingBtn" style="position: fixed; top: 20px; right: 20px; z-index: 999; background-color: #017cff; color: white; border: none; padding: 10px 15px; font-size: 16px; cursor: pointer; border-radius: 5px;"
    onclick="openSetting()">
    ⚙️ Cài đặt
</button>

<!-- MODAL NỘI DUNG PHỤ -->
<div id="myModal" style="display: none; position: fixed; z-index: 1000; width: 100vw; height: 100vh; background-color: rgba(0,0,0,0.7);">
    <div style="background-color: #fefefe; margin: 10% auto; padding: 20px; border: 1px solid #888; width: 50%; position: relative; border-radius: 8px;">
        <span class="close-button" style="position: absolute; top: 10px; right: 15px; font-size: 28px; font-weight: bold; cursor: pointer;" onclick="closeSetting()">&times;</span>
        <h2>Cài đặt</h2>
        <div id="contents"></div>
    </div>
</div>

<!-- CSS MENU -->
<style>
    .menu {
        background-color: #f0f0f0;
        padding: 10px;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    .menu ul {
        list-style-type: none;
        margin: 0;
        padding: 0;
    }
    .menu ul li {
        display: block;
        margin-bottom: 10px;
    }
    .menu ul li a {
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }
    .menu ul li a:hover {
        color: #017cff;
    }
</style>

<!-- SCRIPT JS -->
<script>
    var modal = document.getElementById("myModal");

    function openSetting() {
        modal.style.display = "block";

        $.ajax({
            url: '/vocabulary/process/setting.php',
            method: 'POST',
            data: {type: 'setting'},
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    var $data = data.message;
                    var html = `
                        <form id="settingForm">
                            <div style="margin-bottom: 15px;">
                                <label for="point_jump_word" style="font-size: 18px;">Điểm nhảy (word):</label>
                                <input type="number" id="point_jump_word" name="point_jump_word" value="${$data.point_jump_word ?? ''}" style="font-size: 18px; margin-left: 10px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="point_jump_reading" style="font-size: 18px;">Điểm nhảy (reading):</label>
                                <input type="number" id="point_jump_reading" name="point_jump_reading" value="${$data.point_jump_reading ?? ''}" style="font-size: 18px; margin-left: 10px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="point_jump_speaking" style="font-size: 18px;">Điểm nhảy (speaking):</label>
                                <input type="number" id="point_jump_speaking" name="point_jump_speaking" value="${$data.point_jump_speaking ?? ''}" style="font-size: 18px; margin-left: 10px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="Nx_point" style="font-size: 18px;">Điểm Nx:</label>
                                <input type="number" id="Nx_point" name="Nx_point" value="${$data.Nx_points ?? ''}" style="font-size: 18px; margin-left: 10px;">
                            </div>
                            <button type="button" onclick="saveSetting()" style="font-size: 20px; padding: 8px 20px;">Lưu</button>
                            <button type="button" onclick="closeSetting()" style="font-size: 20px; padding: 8px 20px;">Hủy</button>
                            <button type="button" onclick="window.location.href='/vocabulary/accounts/logout.php'" style="font-size: 20px; padding: 8px 20px;">Đăng xuất</button>
                        </form>
                    `;
                    $('#contents').html(html);
                } else {
                    alert(data.message);
                }
            },
            error: function(error) {
                console.error('Lỗi:', error);
            }
        });
    }

    function saveSetting() {
        var point_jump_word = $('#point_jump_word').val();
        var point_jump_reading = $('#point_jump_reading').val();
        var point_jump_speaking = $('#point_jump_speaking').val();
        var Nx_point = $('#Nx_point').val();
        $.ajax({
            url: '/vocabulary/process/setting.php',
            method: 'POST',
            data: {
                point_jump_word: point_jump_word,
                point_jump_reading: point_jump_reading,
                point_jump_speaking: point_jump_speaking,
                Nx_point: Nx_point
            },
            dataType: 'json',
            success: function(data) {
                if (data.success) {
                    alert('Lưu cài đặt thành công!');
                    closeSetting();
                } else {
                    alert(data.message);
                }
            },
            error: function(error) {
                console.error('Lỗi:', error);
            }
        });
    }

    function closeSetting() {
        modal.style.display = "none";
    }

    window.onclick = function (event) {
        if (event.target == modal) {
            closeSetting();
        }
    }
</script>

<?php include $_SERVER['DOCUMENT_ROOT'] . '/vocabulary/includes/footer.php'; ?>
