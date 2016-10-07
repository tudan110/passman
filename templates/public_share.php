<?php
/*
 * Javascripts
 */
script('passman', 'vendor/angular/angular.min');
script('passman', 'vendor/angular-animate/angular-animate.min');
script('passman', 'vendor/angular-cookies/angular-cookies.min');
script('passman', 'vendor/angular-resource/angular-resource.min');
script('passman', 'vendor/angular-route/angular-route.min');
script('passman', 'vendor/angular-sanitize/angular-sanitize.min');
script('passman', 'vendor/angular-touch/angular-touch.min');
script('passman', 'vendor/angular-local-storage/angular-local-storage.min');
script('passman', 'vendor/angular-off-click/angular-off-click.min');
script('passman', 'vendor/angularjs-datetime-picker/angularjs-datetime-picker.min');
script('passman', 'vendor/ng-password-meter/ng-password-meter');
script('passman', 'vendor/sjcl/sjcl');
script('passman', 'vendor/zxcvbn/zxcvbn');
script('passman', 'vendor/ng-clipboard/clipboard.min');
script('passman', 'vendor/ng-clipboard/ngclipboard');
script('passman', 'vendor/ng-tags-input/ng-tags-input.min');
script('passman', 'vendor/angular-xeditable/xeditable.min');
script('passman', 'vendor/sha/sha');
script('passman', 'vendor/llqrcode/llqrcode');
script('passman', 'vendor/forge.0.6.9.min');
script('passman', 'lib/promise');
script('passman', 'lib/crypto_wrap');


script('passman', 'app/app_public');
script('passman', 'app/controllers/public_shared_credential');
script('passman', 'app/filters/range');
script('passman', 'app/filters/propsfilter');
script('passman', 'app/filters/byte');
script('passman', 'app/services/vaultservice');
script('passman', 'app/services/credentialservice');
script('passman', 'app/services/settingsservice');
script('passman', 'app/services/fileservice');
script('passman', 'app/services/encryptservice');
script('passman', 'app/services/tagservice');
script('passman', 'app/services/notificationservice');
script('passman', 'app/services/shareservice');
script('passman', 'app/directives/otp');
script('passman', 'app/directives/tooltip');
script('passman', 'app/directives/use-theme');
script('passman', 'app/directives/credentialfield');
script('passman', 'app/directives/ngenter');


/*
 * Styles
 */
style('passman', 'vendor/ng-password-meter/ng-password-meter');
style('passman', 'vendor/bootstrap/bootstrap.min');
style('passman', 'vendor/bootstrap/bootstrap-theme.min');
style('passman', 'vendor/font-awesome/font-awesome.min');
style('passman', 'vendor/angular-xeditable/xeditable.min');
style('passman', 'vendor/ng-tags-input/ng-tags-input.min');
style('passman', 'vendor/angularjs-datetime-picker/angularjs-datetime-picker');
style('passman', 'app');
style('passman', 'public-page');

?>
<div ng-app="passmanApp" ng-controller="PublicSharedCredential">
	<div class="row">
		<div class="col-xs-8 col-xs-push-2 col-xs-pull-2 credential_container">
			<h2>Passman</h2>
			<div ng-if="!shared_credential && !expired">
				<span class="text">Someone has shared a credential with you.</span>
				<button class="button-geen" ng-if="!loading"
						ng-click="loadSharedCredential()">Click here to request
					it
				</button>
				<button class="button-geen" ng-if="loading"><i
						class="fa fa-spinner fa-spin"></i>Loading...
				</button>
			</div>
			<div ng-if="expired">
				Awwhh.... credential not found. Maybe it expired
			</div>
			<div ng-if="shared_credential">
				<table class="table">
					<tr ng-show="shared_credential.label">
						<td>
							Label
						</td>
						<td>
							{{shared_credential.label}}
						</td>
					</tr>
					<tr ng-show="shared_credential.username">
						<td>
							Account
						</td>
						<td>
					<span credential-field
						  value="shared_credential.username"></span>
						</td>
					</tr>
					<tr ng-show="shared_credential.password">
						<td>
							Password
						</td>
						<td>
					<span credential-field value="shared_credential.password"
						  secret="'true'"></span>
						</td>
					</tr>
					<tr ng-show="shared_credential.otp.secret">
						<td>
							OTP
						</td>
						<td>
					<span otp-generator
						  secret="shared_credential.otp.secret"></span>
						</td>
					</tr>
					<tr ng-show="shared_credential.email">
						<td>
							E-mail
						</td>
						<td>
					<span credential-field
						  value="shared_credential.email"></span>
						</td>
					</tr>
					<tr ng-show="shared_credential.url">
						<td>
							URL
						</td>
						<td>
					<span credential-field
						  value="shared_credential.url"></span>
						</td>
					</tr>
					<tr ng-show="shared_credential.files.length > 0">
						<td>
							Files
						</td>
						<td>
							<div ng-repeat="file in shared_credential.files"
								 class="link" ng-click="downloadFile(file)">
								{{file.filename}} ({{file.size | bytes}})
							</div>
						</td>
					</tr>
					<tr ng-repeat="field in shared_credential.custom_fields">
						<td>
							{{field.label}}
						</td>
						<td>
					<span credential-field value="field.value"
						  secret="field.secret"></span>
						</td>
					</tr>
					<tr ng-show="shared_credential.expire_time > 0">
						<td>
							Expire time
						</td>
						<td>
							{{shared_credential.expire_time * 1000 |
							date:'dd-MM-yyyy @ HH:mm:ss'}}
						</td>
					</tr>
					<tr ng-show="shared_credential.changed">
						<td>
							Changed
						</td>
						<td>
							{{shared_credential.changed * 1000 |
							date:'dd-MM-yyyy @ HH:mm:ss'}}
						</td>
					</tr>
					<tr ng-show="shared_credential.created">
						<td>
							Created
						</td>
						<td>
							{{shared_credential.created * 1000 |
							date:'dd-MM-yyyy @ HH:mm:ss'}}
						</td>
					</tr>

				</table>

				<div class="tags">
					<span class="tag" ng-repeat="tag in shared_credential.tags">{{tag.text}}</span>

				</div>
			</div>
			<div class="footer">
				<a href="https://github.com/nextcloud/passman" target="_blank" class="link">Github</a> | <a href="https://github.com/nextcloud/passman/wiki" target="_blank" class="link">Wiki</a> | <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=6YS8F97PETVU2" target="_blank" class="link">Donate</a>
			</div>
		</div>
	</div>
</div>