<div class="new-post-div">
    <form method="post" onsubmit="return ValidatePost()" action="index.php" enctype="multipart/form-data">
        <table>
            <tr>
                <td colspan="2">
                    <textarea id="post-area" name="post-content" placeholder="Podijeli svoje misli..." class="common"></textarea>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <input type="file" name="post-image">
                </td>
                <td align="right">
                    <input type="submit" name="submit-post" value="Objavi">
                </td>
            </tr>
        </table>
    </form>
</div>