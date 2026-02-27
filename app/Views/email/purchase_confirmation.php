<!-- app/Views/email/purchase_confirmation.php -->
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<style>
  body { font-family: Georgia, serif; background: #fdf6f0; color: #333; margin: 0; padding: 0; }
  .container { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,.08); }
  .header { background: linear-gradient(135deg, #e91e8c, #9c27b0); padding: 40px; text-align: center; }
  .header h1 { color: #fff; margin: 0; font-size: 28px; }
  .header p { color: rgba(255,255,255,.85); margin: 8px 0 0; }
  .body { padding: 40px; }
  .body h2 { color: #e91e8c; }
  .download-btn { display: block; width: fit-content; margin: 24px auto; padding: 16px 40px; background: linear-gradient(135deg, #e91e8c, #9c27b0); color: #fff; text-decoration: none; border-radius: 50px; font-size: 18px; font-weight: bold; }
  .warning { background: #fff8e1; border-left: 4px solid #ffc107; padding: 16px; border-radius: 8px; margin: 20px 0; font-size: 14px; }
  .footer { background: #f5f5f5; padding: 24px; text-align: center; font-size: 13px; color: #888; }
</style>
</head>
<body>
<div class="container">
  <div class="header">
    <h1>🎉 ¡Tu compra fue exitosa!</h1>
    <p>Gracias por confiar en TechManuals Store</p>
  </div>
  <div class="body">
    <p>Hola <strong><?= esc($userName) ?></strong>,</p>
    <p>Tu pago de <strong>$<?= esc($amount) ?> <?= esc($currency) ?></strong> fue procesado correctamente. Ya puedes descargar tu manual:</p>
    
    <h2><?= esc($manualTitle) ?></h2>

    <a href="<?= esc($downloadLink) ?>" class="download-btn">⬇️ Descargar mi manual</a>

    <div class="warning">
      ⏰ <strong>Importante:</strong> Este link de descarga es de un solo uso y expirará en 
      <strong><?= esc($expiresIn) ?> horas</strong>. Si necesitas un nuevo link, puedes generarlo 
      desde tu sección <a href="#">Mis Compras</a>.
    </div>

    <p>Si tienes algún problema con tu descarga, no dudes en escribirnos a 
       <a href="mailto:soporte@techmanuals.com">soporte@techmanuals.com</a></p>
  </div>
  <div class="footer">
    TechManuals Store © <?= date('Y') ?> · Todos los derechos reservados<br>
    <small>Este es un correo automático, por favor no respondas a este email.</small>
  </div>
</div>
</body>
</html>
