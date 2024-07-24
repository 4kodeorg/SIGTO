<?php
// RUTAS PROTEGIDAS
session_start();
if(isset($_SESSION['username'])) {
require('./headerback.php')
?>

<div class="main-container">
        <div class="navcontainer">
            <nav class="nav">
                <div class="nav-upper-options">
                    <a href="./general.php" class="nav-option option1">
                        <svg width="36px" height="36px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="m1 2l1-1h12l1 1v12l-1 1H2l-1-1V2Zm1 
                    0v12h3V2H2Zm4 0v8h8V2H6Z" />
                            </g>
                        </svg>
                        <h3> Panel</h3>
                    </a>

                    <a href="./productos.php" class="option2 nav-option">
                    <svg width="36px" height="36px" viewBox="0 0 24 24" 
                        fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor"><g fill="none" stroke="currentColor" stroke-linejoin="round" 
                        stroke-width="2"><path stroke-linecap="round" d="M11.029 2.54a2 2 0 0 1 1.942 0l7.515
                        4.174a1 1 0 0 1 .514.874v8.235a2 2 0 0 1-1.029 1.748l-7 3.89a2 2 0 0 1-1.942 0l-7-3.89A2
                        2 0 0 1 3 15.824V7.588a1 1 0 0 1 .514-.874L11.03 2.54Z"/><path stroke-linecap="round" 
                        d="m7.5 4.5l9 5V13M6 12.328L9 14"/><path d="m3 7l9 5m0 0l9-5m-9 5v10"/></g></g>
                    </svg>
                    <h3>Productos</h3>
                    </a>

                    <a href="./estadisticas.php" class="nav-option option3">
                        <svg width="36px" height="36px" viewBox="0 0 36 36" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="M32 5H4a2 2 0 0 0-2 2v22a2 2 0 0 0 2 2h28a2 2 0 0 0
                        2-2V7a2 2 0 0 0-2-2ZM4 29V7h28v22Z" class="clr-i-outline clr-i-outline-path-1" />
                                <path fill="currentColor" d="m15.62 15.222l-6.018 8.746l-4.052-3.584l1.06-1.198l2.698 
                        2.386l6.326-9.192l6.75 10.015l6.754-8.925l1.276.966l-8.106 10.709z" class="clr-i-outline clr-i-outline-path-2" />
                                <path fill="none" d="M0 0h36v36H0z" />
                            </g>
                        </svg>
                        <h3>Estadísticas</h3>
                    </a>

                    <a href="./company.php" class="nav-option option4">
                        <svg width="36px" height="36px" viewBox="0 0 512 512" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                            <path fill="currentColor" d="M393.674 430.14V448H54.326l.004-17.86zm-13.395-26.791v22.325H67.721V403.35zM100.452
                            162.233l3.726 1.883l1.864 30.11l1.865 48.928v47.055l-1.865 58.656l-.31 39.515l-5.28 
                            1.573H81.816l-5.59-1.573l-2.172-39.515l-1.868-58.343v-47.051l1.868-49.244l1.704-30.273l3.887-1.721zm267.909
                            0l3.73 1.883l1.861 30.11l1.862 48.928v47.055l-1.862 58.656l-.306 39.515l-5.285 
                            1.573h-18.636l-5.592-1.573l-2.179-39.515l-1.861-58.343v-47.051l1.861-49.244l1.712-30.273l3.884-1.721zm-187.538
                            0l3.726 1.883l1.865 30.11l1.865 48.928v47.055l-1.865 58.656l-.307 39.515l-5.284 
                            1.573h-18.638l-5.594-1.573l-2.172-39.515l-1.86-58.343v-47.051l1.86-49.244l1.712-30.273l3.88-1.721zm102.698 0l3.726 
                            1.883l1.865 30.11l1.865 48.928v47.055l-1.865 58.656l-.307 39.515l-5.284 
                            1.573h-18.638l-5.59-1.573l-2.176-39.515l-1.861-58.343v-47.051l1.861-49.244l1.712-30.273l3.883-1.721zm96.758-40.186v31.255H67.721v-31.255ZM220.785 
                            64l163.96 37.546l-6.574 11.57H64.15l-9.823-9.383z" /></g>
                        </svg>
                        <h3> Empresa</h3>
                    </a>

                    <a href="./profile.php" class="nav-option option5">
                        <svg width="36px" height="36px" viewBox="0 0 16 16" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="M16 7.992C16 3.58 12.416 0 8 0S0 3.58 0 7.992c0 
                            2.43 1.104 4.62 2.832 6.09c.016.016.032.016.032.032c.144.112.288.224.448.336c.08.048.144.111.224.175A7.98 
                            7.98 0 0 0 8.016 16a7.98 7.98 0 0 0 4.48-1.375c.08-.048.144-.111.224-.16c.144-.111.304-.223.448-.335c.016-.016.032-.016.032-.032c1.696-1.487 
                            2.8-3.676 2.8-6.106zm-8 7.001c-1.504 0-2.88-.48-4.016-1.279c.016-.128.048-.255.08-.383a4.17 
                            4.17 0 0 1 .416-.991c.176-.304.384-.576.64-.816c.24-.24.528-.463.816-.639c.304-.176.624-.304.976-.4A4.15 
                            4.15 0 0 1 8 10.342a4.185 4.185 0 0 1 2.928 1.166c.368.368.656.8.864 1.295c.112.288.192.592.24.911A7.03 
                            7.03 0 0 1 8 14.993zm-2.448-7.4a2.49 2.49 0 0 1-.208-1.024c0-.351.064-.703.208-1.023c.144-.32.336-.607.576-.847c.24-.24.528-.431.848-.575c.32-.144.672-.208 1.024-.208c.368 
                            0 .704.064 1.024.208c.32.144.608.336.848.575c.24.24.432.528.576.847c.144.32.208.672.208 1.023c0 .368-.064.704-.208 1.023a2.84 2.84 
                            0 0 1-.576.848a2.84 2.84 0 0 1-.848.575a2.715 2.715 0 0 1-2.064 0a2.84 2.84 0 0 1-.848-.575a2.526 2.526 0 0 1-.56-.848zm7.424 5.306c0-.032-.016-.048-.016-.08a5.22 
                            5.22 0 0 0-.688-1.406a4.883 4.883 0 0 0-1.088-1.135a5.207 5.207 0 0 0-1.04-.608a2.82 2.82 0 0 0 .464-.383a4.2 4.2 0 0 0 .624-.784a3.624 3.624 0 0 0 
                            .528-1.934a3.71 3.71 0 0 0-.288-1.47a3.799 3.799 0 0 0-.816-1.199a3.845 3.845 0 0 0-1.2-.8a3.72 3.72 0 0 0-1.472-.287a3.72 3.72 0 0 0-1.472.288a3.631 3.631 0 
                            0 0-1.2.815a3.84 3.84 0 0 0-.8 1.199a3.71 3.71 0 0 0-.288 1.47c0 .352.048.688.144 1.007c.096.336.224.64.4.927c.16.288.384.544.624.784c.144.144.304.271.48.383a5.12 5.12 0
                            0 0-1.04.624c-.416.32-.784.703-1.088 1.119a4.999 4.999 0 0 0-.688 1.406c-.016.032-.016.064-.016.08C1.776 11.636.992 9.91.992 7.992C.992 4.14 4.144.991 8 .991s7.008 
                            3.149 7.008 7.001a6.96 6.96 0 0 1-2.032 4.907z" />
                            </g>
                        </svg>
                        <h3> Perfil</h3>
                    </a>

                    <a href="./logout.php" class="nav-option logout">
                        <svg width="36px" height="36px" viewBox="0 0 36 36" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                            <g fill="currentColor">
                                <path fill="currentColor" d="M7 6h16v9.8h2V6a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2v24a2 2 
                        0 0 0 2 2h16a2 2 0 0 0 2-2H7Z" class="clr-i-outline clr-i-outline-path-1" />
                                <path fill="currentColor" d="M28.16 17.28a1 1 0 0 0-1.41 1.41L30.13 22h-14.5a1 1 0 0 0-1 
                        1a1 1 0 0 0 1 1h14.5l-3.38 3.46a1 1 0 1 0 1.41 1.41l5.84-5.8Z" class="clr-i-outline 
                        clr-i-outline-path-2" />
                                <path fill="none" d="M0 0h36v36H0z" />
                            </g>
                        </svg>
                        <h3>Cerrar sesión</h3>
                    </a>

                </div>
            </nav>
        </div>
        
        

<div class="main">

            <div class="searchbar2">
                <input type="text" name="" id="" placeholder="Search">
                <div class="searchbtn">
                    <svg width="30px" height="30px" viewBox="0 0 24 24" fill="currentColor" x="128" y="128" role="img" xmlns="http://www.w3.org/2000/svg">
                        <g fill="currentColor">
                            <path fill="currentColor" d="M15.25 0a8.25 8.25 0 0 0-6.18 13.72L1 22.88l1.12 
                    1l8.05-9.12A8.251 8.251 0 1 0 15.25.01V0zm0 15a6.75 6.75 0 1 1 0-13.5a6.75 6.75 
                    0 0 1 0 13.5z" />
                        </g>
                    </svg>
                </div>
            </div>

            <div class="box-container">

            </div>

            <div class="report-container">
                <div class="report-header">
                    <h1 class="recent-Articles">Articulos recientes</h1>
                    <button class="view">Ver todos</button>
                </div>
            </div>
            </div>
</div>
</div>

<?php
}
else {
    header('Location: index.html');
    exit();
}
?>