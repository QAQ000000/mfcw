<section class="admin-main">
  <div class="container-fluid">
    <div class="page-container">
      <div class="card">
        <div class="card-body">
          <div class="card-title row">
            <div style="padding: 0 15px;">{$Title}</div>
            <div class="col-lg-8 col-md-12 col-sm-12">
              {foreach $PluginsAdminMenu as $v}
                {if $v['custom']}
                  <span class="ml-2"><a class="h5" href="{$v.url}" target="_blank">{$v.name}</a></span>
                {else/}
                  <span class="ml-2"><a class="h5" href="{$v.url}">{$v.name}</a></span>
                {/if}
              {/foreach}
            </div>
          </div>

          <div class="tab-content mt-4">
            <form method="post" class="form" action="{:shd_addon_url('SmsRateLimit://AdminIndex/setting')}">
              <h5 class="mb-3">短信验证码</h5>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">同一手机号冷却时间（秒）</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="cooldown_seconds" min="0" max="3600" value="{$config.cooldown_seconds}" required>
                  <small class="form-text text-muted">所有短信验证码入口共用，范围 0-3600 秒，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">单手机号每日上限</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="phone_daily_limit" min="0" max="1000" value="{$config.phone_daily_limit}" required>
                  <small class="form-text text-muted">同一个手机号每日允许的短信发送尝试次数，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">短信全站每分钟上限</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="global_minute_limit" min="0" max="100000" value="{$config.global_minute_limit}" required>
                  <small class="form-text text-muted">达到上限后，本分钟内的新请求将被拒绝，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">短信全站每日上限</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="global_daily_limit" min="0" max="1000000" value="{$config.global_daily_limit}" required>
                  <small class="form-text text-muted">达到上限后，当天的新请求将被拒绝，0 为不限。</small>
                </div>
              </div>
              <hr class="my-4">
              <h5 class="mb-3">邮件验证码</h5>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">同一邮箱冷却时间（秒）</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="email_cooldown_seconds" min="0" max="3600" value="{$config.email_cooldown_seconds}" required>
                  <small class="form-text text-muted">所有邮件验证码入口共用，范围 0-3600 秒，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">单邮箱每日上限</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="email_daily_limit" min="0" max="1000" value="{$config.email_daily_limit}" required>
                  <small class="form-text text-muted">同一个邮箱每日允许的验证码邮件发送尝试次数，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">邮件全站每分钟上限</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="email_global_minute_limit" min="0" max="100000" value="{$config.email_global_minute_limit}" required>
                  <small class="form-text text-muted">达到上限后，本分钟内的新邮件验证码请求将被拒绝，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">邮件全站每日上限</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" name="email_global_daily_limit" min="0" max="1000000" value="{$config.email_global_daily_limit}" required>
                  <small class="form-text text-muted">达到上限后，当天的新邮件验证码请求将被拒绝，0 为不限。</small>
                </div>
              </div>
              <div class="form-group row">
                <div class="col-sm-7 offset-sm-3">
                  <button type="submit" class="btn btn-primary w-md">保存更改</button>
                  <button type="button" class="btn btn-outline-secondary w-md" onclick="location.reload();">取消更改</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
