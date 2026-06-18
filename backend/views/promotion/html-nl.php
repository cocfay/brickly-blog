<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>NL WeclickDigital</title>
  </head>
  <body style="margin:0; padding:0; background-color:#f4f4f4;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:20px;">
      <tr>
        <td align="center">
          <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color:#ffffff; padding:20px; border-radius:8px;">
            <tr>
              <td align="center" style="padding: 10px 20px; font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                <!-- Descripción debajo -->
                <?= $pretext; ?>
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 20px 0;">
                <!-- Imagen central -->
                <img src="<?= $image; ?>" alt="Imagen principal" width="400" style="display: block; border: 0; max-width: 100%; height: auto;" />
              </td>
            </tr>
            <tr>
              <td align="center" style="padding: 10px 20px; font-family: Arial, sans-serif; font-size: 16px; color: #333;">
                <!-- Descripción debajo -->
                <?= $description; ?>
              </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>