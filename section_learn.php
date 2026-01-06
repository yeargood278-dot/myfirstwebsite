<?php 
include 'data_zoo.php'; 
$id = $_GET['id'] ?? 'c1s1';
$content = $courses[$id] ?? $courses['c1s1'];
$slides = $content['ppt'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title><?php echo $content['title']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        body { background: #e0f7fa; font-family: 'Segoe UI', sans-serif; height: 100vh; overflow: hidden; display: flex; flex-direction: column; }
        .stage { flex: 1; display: flex; align-items: center; justify-content: center; background: linear-gradient(to bottom, #b3e5fc, #fff); }
        .slide-card { width: 90%; max-width: 960px; height: 85vh; background: white; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.1); display: none; flex-direction: column; overflow: hidden; border: 1px solid #b3e5fc; position: relative; }
        .slide-card.active { display: flex; }
        .role-header { padding: 25px 40px; color: white; display: flex; align-items: center; justify-content: space-between; }
        .role-avatar { font-size: 3.5rem; filter: drop-shadow(2px 2px 0 rgba(0,0,0,0.2)); }
        .content-body { padding: 30px 50px; flex: 1; overflow-y: auto; font-size: 1.5rem; color: #333; line-height: 1.6; }
        .nav-bar { background: white; padding: 15px; text-align: center; border-top: 1px solid #eee; }
        
        /* === 视觉素材库 === */
        .visual-box { margin: 20px auto; text-align: center; height: 350px; display:flex; align-items:center; justify-content:center; overflow:hidden; border-radius:15px; background:#f8f9fa; position:relative; }
        .icon-large { font-size: 8rem; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }

        /* 太阳系动画 */
        .css-solar { width:300px; height:300px; position:relative; }
        .sun { width:50px; height:50px; background:gold; border-radius:50%; position:absolute; top:125px; left:125px; box-shadow:0 0 30px gold; animation: pulse 2s infinite; }
        .orbit { border:1px solid #ccc; border-radius:50%; position:absolute; top:50%; left:50%; transform:translate(-50%,-50%); animation: spin 6s linear infinite; }
        .planet { width:15px; height:15px; background:blue; border-radius:50%; position:absolute; top:-7px; left:50%; margin-left:-7px; }
        @keyframes spin { 100% { transform:translate(-50%,-50%) rotate(360deg); } }

        /* 热力环流 */
        .css-thermal { width:300px; height:200px; border-bottom:5px solid #555; position:relative; }
        .arrow { font-size:30px; position:absolute; font-weight:bold; }
        .a-up { color:red; left:40px; animation: up 2s infinite; }
        .a-down { color:blue; right:40px; animation: down 2s infinite; }
        .a-flow { color:#555; top:20px; left:130px; animation: right 2s infinite; }
        @keyframes up { 0%{bottom:0;opacity:0} 50%{bottom:120px;opacity:1} 100%{bottom:120px;opacity:0} }
        @keyframes down { 0%{top:20px;opacity:0} 50%{top:140px;opacity:1} 100%{top:140px;opacity:0} }
        @keyframes right { 0%{transform:translateX(-20px);opacity:0} 50%{transform:translateX(0);opacity:1} 100%{transform:translateX(20px);opacity:0} }

        /* 水循环 */
        .css-water-cycle { width:400px; height:300px; position:relative; overflow:hidden; }
        .ocean { width:100%; height:50px; background:#2980b9; position:absolute; bottom:0; }
        .land { width:150px; height:100px; background:#27ae60; position:absolute; bottom:0; right:0; border-radius:50px 0 0 0; }
        .vapour { font-size:40px; position:absolute; left:50px; animation: rise 3s infinite; }
        .rain { font-size:40px; position:absolute; right:50px; top:50px; animation: fall 1s infinite; color:#3498db; }
        @keyframes rise { 0%{bottom:50px;opacity:1} 100%{bottom:200px;opacity:0} }
        @keyframes fall { 0%{top:50px;opacity:0} 50%{top:150px;opacity:1} }

        /* 通用 CSS 组件 */
        .css-nuclear { font-size:3rem; font-weight:bold; color:#e67e22; animation: pulse 1s infinite; }
        .css-seismic { width:300px; height:100px; background: repeating-linear-gradient(90deg, #333, #333 2px, transparent 2px, transparent 20px); animation: shake 0.5s infinite; }
        @keyframes shake { 0%{transform:translateX(0)} 25%{transform:translateX(5px)} 75%{transform:translateX(-5px)} 100%{transform:translateX(0)} }
        
        .web-img { height: 100%; width: auto; object-fit: contain; }
    </style>
</head>
<body>
    <div class="stage">
        <?php foreach($slides as $k => $s): ?>
        <?php 
            $color = '#3498db'; $emoji = '🐰'; $name = '朱迪警官';
            if($s['role']=='nick') { $color='#e67e22'; $emoji='🦊'; $name='尼克'; }
            if($s['role']=='flash') { $color='#27ae60'; $emoji='🦥'; $name='闪电'; }
            if($s['role']=='bogo') { $color='#2c3e50'; $emoji='🐃'; $name='牛局长'; }
        ?>
        <div class="slide-card animate__animated animate__<?php echo $s['anim_type'] ?? 'fadeIn'; ?>" id="slide-<?php echo $k; ?>">
            <div class="role-header" style="background: <?php echo $color; ?>">
                <div><h2 class="m-0 fw-bold"><?php echo $s['title']; ?></h2><span style="opacity:0.9"><?php echo $name; ?></span></div>
                <div class="role-avatar"><?php echo $emoji; ?></div>
            </div>
            <div class="content-body">
                <?php echo $s['content']; ?>
                <div class="visual-box">
                    <?php 
                        $v = $s['visual'] ?? 'icon_star';
                        // CSS 动画
                        if ($v == 'css_solar_system') echo '<div class="css-solar"><div class="sun"></div><div class="orbit" style="width:200px;height:200px"><div class="planet"></div></div></div>';
                        elseif ($v == 'css_thermal') echo '<div class="css-thermal"><div class="arrow a-up">🔥</div><div class="arrow a-down">❄️</div><div class="arrow a-flow">➡️</div></div>';
                        elseif ($v == 'css_water_cycle') echo '<div class="css-water-cycle"><div class="ocean"></div><div class="land"></div><div class="vapour">♨️</div><div class="rain">💧</div></div>';
                        elseif ($v == 'css_nuclear') echo '<div class="css-nuclear">H+H 💥 He</div>';
                        elseif ($v == 'css_seismic') echo '<div class="css-seismic"></div>';
                        // 外部图片 (维基百科)
                        elseif (strpos($v, 'http') === 0) echo "<img src='$v' class='web-img'>";
                        // 默认图标
                        elseif (strpos($v, 'icon_') === 0) {
                            $i='🌟';
                            if($v=='icon_earth') $i='🌍'; elseif($v=='icon_rock') $i='🪨'; elseif($v=='icon_life') $i='🧬';
                            elseif($v=='icon_water_drop') $i='💧'; elseif($v=='icon_dam') $i='🏗️'; elseif($v=='icon_surf') $i='🏄';
                            echo '<div class="icon-large">'.$i.'</div>';
                        }
                        else echo '<div class="icon-large">🖼️</div>';
                    ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="nav-bar">
        <button class="btn btn-secondary rounded-pill px-4" onclick="move(-1)">上一页</button>
        <span class="mx-3 fw-bold text-muted" id="pg-num">1 / <?php echo count($slides); ?></span>
        <button class="btn btn-primary rounded-pill px-5 fw-bold" id="next-btn" onclick="move(1)">下一页</button>
    </div>
    <script>
        let cur = 0; const total = <?php echo count($slides); ?>;
        const currentId = '<?php echo $id; ?>';
        function show(idx) {
            document.querySelectorAll('.slide-card').forEach(el => el.classList.remove('active'));
            document.getElementById('slide-' + idx).classList.add('active');
            cur = idx; document.getElementById('pg-num').innerText = (cur + 1) + " / " + total;
            const btn = document.getElementById('next-btn');
            if(cur === total - 1) { 
                btn.innerText = "进入考核 📝"; btn.classList.replace('btn-primary', 'btn-success'); 
                btn.onclick = () => window.location.href = 'quiz.php?id=' + currentId; 
            } else { 
                btn.innerText = "下一页"; btn.classList.replace('btn-success', 'btn-primary'); 
                btn.onclick = () => move(1); 
            }
        }
        function move(dir) { if(cur + dir >= 0 && cur + dir < total) show(cur + dir); }
        window.onload = function() { show(0); };
    </script>
</body>
</html>