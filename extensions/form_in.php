<div class="col-sm-8">
    <form name="loginform" class="loginform" action="<?php echo htmlspecialchars( $_SERVER["PHP_SELF"]);?>" method="post">
        <fieldset id="formback">
            <legend><h5>Login with Staff id</h5></legend>
            <div class="head"><font style='font-size:15px; margin-left:10px; color:red'><?php echo($message);?></font></div></h5>
            <!--<div class="input-container m-5">-->
            <div class="m-5">
                <i class="fa fa-user icon"></i>
                <input class="input-field" type="text" id="spNumber"  name="spNumber" placeholder="e.g SP000">
            </div>
            <button type="submit" name="submitLogin" value="Login" class="btn btn-info submit">Login</button>
        </fieldset>
    </form>
</div>