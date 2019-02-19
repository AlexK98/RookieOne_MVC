<h2>Dummy Section</h2>
<form method="post" class="form iblock formTopLine pa20" action="/admin" novalidate>
	<p class="msg">Status: <?php if (isset($message)) { echo $message; } ?></p>
	<input type="hidden"/>
	<button type="submit" class="btn fs18 btn2 mt10" name="submit" value="createDB" title="Dummy: Create DB">Create DB</button>
	<button type="submit" class="btnR fs18 btn2 mt10" name="submit" value="dropDB" title="Dummy: Delete DB">Drop DB</button>
</form>