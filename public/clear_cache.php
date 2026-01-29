<?php
// Clear application cache
shell_exec('php artisan cache:clear');
// Clear route cache
shell_exec('php artisan route:clear');
// Clear config cache
shell_exec('php artisan config:clear');
// Clear view cache
shell_exec('php artisan view:clear');
?>