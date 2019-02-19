<h2 class="block mt20">Sign Up! </h2>
<div class="iblock width456">Hey<b class="col_green"><?php if (isset($basename) && !empty($basename)) {echo ' '.$basename;}?></b>! Fill in this form, click '<b class="col_green">Sign Up</b>' and<br>start enjoying the wanders we build for you.</div>

<section class="block mt20">
	<form class="form width456 iblock formTopLine pa20" method="post" action="/signup" autocomplete="off" novalidate>
		<!--FIRSTNAME-->
		<label for="firstname" id="l_firstname" class="label block"><span class="redmark" title="Required">*</span> First Name:</label>
		<input type="text" id="name" name="firstname" required title="Please enter your First name"
		       class="form_input <?php if (isset($phFirstStyle)) {echo $phFirstStyle;}?>"
		       placeholder="<?php if (isset($phFirst)) {echo $phFirst;} ?>"
		       value="<?php if (isset($firstname) && !empty($firstname)) {echo $firstname;} ?>"/>
		<!--LASTNAME-->
		<label for="lastname" id="l_lastname" class="label block"><span class="redmark" title="Required">*</span> Last Name:</label>
		<input type="text" id="lastname" name="lastname" required title="Please enter your Last name"
		       class="form_input <?php if (isset($phLastStyle)) {echo $phLastStyle;}?>"
		       placeholder="<?php if (isset($phLast)) {echo $phLast;} ?>"
		       value="<?php if (isset($lastname) && !empty($lastname)) {echo $lastname;} ?>"/>
		<!--EMAIL-->
		<label for="email" id="l_email" class="label block"><span class="redmark" title="Required">*</span> Email:</label>
		<input type="email" id="email" name="email" required title="Please enter valid e-mail address"
		       class="form_input <?php if (isset($phEmailStyle)) {echo $phEmailStyle;}?>"
		       placeholder="<?php if (isset($phEmail)) {echo $phEmail;} ?>"
		       value="<?php if (isset($email) && !empty($email)) {echo $email;} ?>"/>
		<!--PASSWORD-->
		<label for="password" id="l_password" class="label block"><span class="redmark" title="Required">*</span> Password:</label>
		<input type="password" id="password" name="password" required
		       title="Must contain at least one number and one uppercase and lowercase letter, and be at least three or more characters long"
		       pattern="(?=.*\d)(?=.*[a-zа-я])(?=.*[A-ZА-Я]).{3,100}$"
		       class="form_input <?php if (isset($phPassStyle)) {echo $phPassStyle;}?>"
		       placeholder="<?php if (isset($phPass)) {echo $phPass;} ?>"
		<!--SHOW PASSWORD-->
		<label class="chbox_container">Show Password
			<input type="checkbox" onclick="FormShowPassword()">
			<span class="chbox_checkmark"></span>
		</label>
		<!--FORM BUTTONS-->
		<button type="submit" class="btn fs18 btn1" name="submit" value="SignUp" onclick="ToggleText2Pass()">Sign Up</button>
		<button type="reset" class="btn fs18 btn1">Reset</button>

		<div class="smaller fs12 mt20">Already wandering with us? <a href="/signin" class="smaller fs12">Sign In</a>.</div>
	</form>
</section>