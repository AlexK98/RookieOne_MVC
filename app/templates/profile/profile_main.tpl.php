<h2>Profile</h2>

<!--PROFILE IMAGE-->
<section class="block mb20">
	<form class="form width678 iblock formTopLine pa20" action="/profile" method="post" enctype="multipart/form-data">
		<!--User Image -->
		<div class="profile pb10">
			<div class="profile-label pt05"></div>
			<div class="pt05">
				<div id="yourBtn" onclick="ChooseFile()">
					<img src="<?php if (isset($userImage)) {echo $userImage;} ?>" class="userPic iblock float_L userPicShadow"
					     id="profileImage" title="Click to change your image." alt="Profile Image">
				</div>
			</div>
		</div>
		<!-- Select Image and Save/Submit button -->
		<div class="profile pt10">
			<div class="profile-label pt05"></div>
			<div class="profile-label pt05">
				<input type="file" name="file2Upload" id="file2Upload" class="hidden_overflow" onchange="PreviewImage(event)"/>
				<button type="submit" name="submit" value="UserImage" id="imageButton" class="btn fs18 btn2 float_L">Save</button>
			</div>
			<div id="imgMsg" class="<?php if(isset($msgImageStyle)){echo $msgImageStyle;} ?> pt05"><?php if(isset($msgImage)){echo $msgImage;} ?></div>
		</div>
	</form>
</section>

<!--PROFILE DATA-->
<section class="block">
	<form class="form width678 iblock formTopLine pa20" action="/profile" method="post" novalidate>
		<!--FIRSTNAME-->
		<div class="profile">
			<div class="profile-label pt05">First Name:</div>
			<div class="pt05">
				<input type="text" id="name" name="firstname" required title="Please enter your First name"
				       class="input-area <?php if (isset($phFirstStyle)) {echo $phFirstStyle;}?>"
				       placeholder="<?php if (isset($phFirst)) {echo $phFirst;} ?>"
				       value="<?php if (isset($firstname) && !empty($firstname)) {echo $firstname;} ?>"/>
			</div>
		</div>
		<!--LASTNAME-->
		<div class="profile pt10">
			<div class="profile-label">Last Name:</div>
			<div>
				<input type="text" id="lastname" name="lastname" required title="Please enter your Last name"
				       class="input-area <?php if (isset($phLastStyle)) {echo $phLastStyle;}?>"
				       placeholder="<?php if (isset($phLast)) {echo $phLast;} ?>"
				       value="<?php if (isset($lastname) && !empty($lastname)) {echo $lastname;} ?>"/>
			</div>
		</div>
		<!--ABOUT-->
		<div class="profile pt10 pb15">
			<div class="profile-label">About:</div>
			<div>
				<textarea name="about" id="about" rows="3" maxlength=255 title="Please tell something about yourself. Up to 255 characters."
				          class="input-area"
				          placeholder="<?php if (isset($phAbout)) {echo $phAbout;} ?>"><?php if (isset($about) && !empty($about)) { echo $about; } ?></textarea>
			</div>
		</div>
		<!--CITY-->
		<div class="profile pt10">
			<div class="profile-label">City:</div>
			<div>
				<input type="text" id="city" name="city" title="Please enter your City"
				       class="input-area"
				       placeholder="<?php if (isset($phCity)) {echo $phCity;} ?>"
				       value="<?php if (!empty($city)) { echo $city; } ?>"/>
			</div>
		</div>
		<!--COUNTRY-->
		<div class="profile pt10">
			<div class="profile-label">County:</div>
			<div>
				<input type="text" id="country" name="country" title="Please select your Country"
				       class="input-area"
				       placeholder="<?php if (isset($phCountry)) {echo $phCountry;} ?>"
				       value="<?php if (isset($country) && !empty($country)) { echo $country; } ?>"/>
			</div>
		</div>
		<!--GENDER-->
		<div class="profile pt10">
			<div class="profile-label">Gender:</div>
			<div>
				<input type="text" id="gender" name="gender" title="Please enter your gender"
				       class="input-area"
				       placeholder="<?php if (isset($phGender)) {echo $phGender;} ?>"
				       value="<?php if (isset($gender) && !empty($gender)) { echo $gender; } ?>"/>
			</div>
		</div>
		<!--FORM BUTTON-->
		<div class="profile pt10">
			<div class="profile-label pt05"></div>
			<div class="profile-label pt05">
				<button type="submit" name="submit" value="UserData" class="btn fs18 btn2 float_L" onclick="ToggleText2Pass()">Save</button>
			</div>
			<div class="<?php if(isset($msgDataStyle)){echo $msgDataStyle;}?> pt05"><?php if(isset($msgData)){echo $msgData;} ?></div>
		</div>
	</form>
</section>