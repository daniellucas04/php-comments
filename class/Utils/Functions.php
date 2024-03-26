<?php 

namespace Utils;

class Functions {
    /**
     * @param string $url = link para o qual o usuário será redirecionado
     * @param int $number = tempo que levará para o usuário ser redirecionado
     */
    public static function location($url = '', $timeout = 0) {
        echo "<script>setTimeout(function(){window.location = 'http://tasks.localhost/$url'}, $timeout)</script>";
    }

    /**
     * Recarrega a página
     */
    public static function reload() {
        session_start();
        if (!isset($_SESSION['reloaded'])) {
            // Sua lógica aqui

            // Define a variável de sessão
            $_SESSION['reloaded'] = true;

            // Recarrega a página
            echo '<script type="text/javascript">location.reload();</script>';
        }
    }

    /**
     * @param string $date = 2024-01-31T02:42:59.000Z
     * @return string 31/01/2024 02:42:59
     */
    public static function brazilianDate(string $date, $hour = false) {
        if ( $hour ) {
            return date('d/m/Y H:i:s', strtotime($date));
        } else {
            return date('d/m/Y', strtotime($date));
        }
    }

    /**
     * @param string $date = 31/01/2024 02:42:59
     * @return string 31/01/2024
     */
    public static function removeTime(string $date) {
        $date = explode(' ', $date);
        return $date[0];
    }
}
?>