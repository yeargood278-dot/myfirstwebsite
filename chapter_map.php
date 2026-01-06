<?php include 'data_zoo.php'; ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <title>警校作战地图</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/mermaid/dist/mermaid.min.js"></script>
    <style>
        body { background: #eef2f3; height: 100vh; display: flex; flex-direction: column; overflow: hidden; }
        .navbar { background: white; box-shadow: 0 2px 5px rgba(0,0,0,0.05); z-index: 10; padding: 10px 30px; }
        .map-viewport { flex: 1; width: 100%; overflow: auto; display: flex; justify-content: flex-start; align-items: center; padding: 50px; background-color: #f8f9fa; background-image: radial-gradient(#dee2e6 1px, transparent 1px); background-size: 20px 20px; }

        /* === 交互核心代码 (强制生效) === */
        g.node rect, g.node circle, g.node polygon {
            stroke: #2980b9 !important; stroke-width: 2px !important; cursor: pointer !important; 
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275) !important;
            filter: drop-shadow(4px 4px 0px rgba(0,0,0,0.15)) !important; /* 3D投影 */
        }
        /* 悬停 (Hover) */
        g.node:hover rect, g.node:hover circle {
            fill: #f39c12 !important; stroke: #d35400 !important;
            transform: translateY(-4px) scale(1.02); filter: drop-shadow(8px 8px 2px rgba(0,0,0,0.2)) !important;
        }
        /* 按压 (Active) */
        g.node:active rect, g.node:active circle {
            transform: translateY(2px) scale(0.98) !important; filter: drop-shadow(1px 1px 0px rgba(0,0,0,0.2)) !important;
            fill: #e74c3c !important;
        }
        /* 文字穿透 */
        g.node .label { pointer-events: none; font-weight: bold; color: white !important; }
        .mermaid svg { min-width: 1500px !important; height: auto; }
    </style>
</head>
<body>
    <nav class="navbar">
        <span class="navbar-brand fw-bold text-primary">🗺️ 警校作战地图 (点击按钮进入)</span>
        <a href="index.php" class="btn btn-outline-secondary btn-sm">返回首页</a>
    </nav>
    <div class="map-viewport">
        <div class="mermaid">
            <?php echo $b1_mindmap; ?>
        </div>
    </div>
    <script>
        mermaid.initialize({ startOnLoad: true, theme: 'base', securityLevel: 'loose', flowchart: { useMaxWidth: false, htmlLabels: true, curve: 'basis' } });
    </script>
</body>
</html>