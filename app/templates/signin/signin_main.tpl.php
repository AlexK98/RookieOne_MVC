<h2 class="block mt20">Sign In</h2>
<p>
	Welcome<?php if (isset($basename) && !empty($basename)) {echo $basename;}?>!
	<br>
	Sign In to access your profile and track your wanders.
</p>

<section class="block mt20">
	<form class="form width456 iblock formTopLine pa20" method="post" autocomplete="off" novalidate
	      action="/signin">
		<!--EMAIL-->
		<label for="email" id="l_email" class="label block"><span class="redmark" title="Required">*</span> Email:</label>
		<input type="email" id="email" name="email" required title="Please enter valid e-mail address"
		       class="form_input <?php if (isset($phEmailStyle)) {echo $phEmailStyle;}?>"
		       placeholder="<?php if (isset($phEmail)) {echo $phEmail;} ?>"
		       value="<?php if (isset($email) && !empty($email)) {echo $email;} ?>"/>
		<!--PASSWORD-->
		<label for="password" id="l_password" class="label block"><span class="redmark" title="Required">*</span> Password:</label>
		<input type="password" id="password" name="password" required title="Your password, please."
		       pattern=".{3,100}"
		       class="form_input <?php if (isset($phPassStyle)) {echo $phPassStyle;}?>"
		       placeholder="<?php if (isset($phPass)) {echo $phPass;} ?>"
		<!--SHOW PASSWORD-->
		<label class="chbox_container">Show Password
			<input type="checkbox" onclick="FormShowPassword()">
			<span class="chbox_checkmark"></span>
		</label>
		<!--FORM BUTTONS-->
		<button type="submit" class="btn fs18 btn1 mt10" name="submit" value="SignIn" onclick="ToggleText2Pass()">Sign In</button>

		<div class="smaller fs12 mt20">Still not wandering with us? <a href="/signup" class="smaller fs12">Sign Up</a>.</div>
	</form>
</section>