<table width="720">
    <tbody>
        <tr>
            <td width="10" vAlign=top><img src="images/fader.gif" border="0"></td>
            <td width="710" vAlign=top><img src="images/topfader.gif" border="0">
                <br>
                    <!-- About us -->
                &nbsp;&nbsp;<img src="images/menu/textmenu_aboutus.gif" border="0">
                <br>
                <table width="700" align="center">
                    <tr>
                        <td height="1" class="dotline"></td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                            <?php
                            $contents = file_get_contents('aboutus/aboutus.html');
                            echo stripslashes($contents);
                            ?>
                            <br>
                            <br>
                        </td>
                    </tr>
                </table>
                <br>
                <br>
                <!-- About us -->
            </td>
        </tr>
    </tbody>
</table>
