{if !$LOGGED && $status != 'success'}
	{if isset($error_msg) && $error_msg}<div>{$error_msg}</div>{/if}
	<form action="/register" method="post">
		<label class="block">Login: <input type="text" name="signup[login]" placeholder="vpupkin" value=""></label>
		<label class="block">Password: <input type="password" name="signup[password]" placeholder="not 11-12-1988" value=""></label>
		<label class="block">Password (repeat): <input type="password" name="signup[password_repeat]" placeholder="" value=""></label>
		<label class="block">E-mail: <input type="text" name="signup[email]" placeholder="v.pupkin@gmail.com" value=""></label>
		<label class="block">First name: <input type="text" name="signup[fname]" placeholder="Vasia" value=""></label>
		<label class="block">Last name: <input type="text" name="signup[lname]" placeholder="Pupkin" value=""></label>
		<label class="block">Sex: <input type="text" name="signup[sex]" placeholder="" value="1"></label>
		<input type="submit" value="Sign-up">
	</form>
{elseif !$LOGGED && $status == 'success'}
	<h1>Hoorey! You`ve successfull registered!</h1>
{else}
	<h1>You already registered</h1>
{/if}