<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>NT6 — Autenticación y Autorización en Laravel</title>
<style>
/* ─── Reset & base ─────────────────────────────────────────── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body {
    font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
    background: #f8fafc;
    color: #1e293b;
    line-height: 1.65;
    font-size: 15px;
}

/* ─── Contenedor principal ─────────────────────────────────── */
.page {
    max-width: 860px;
    margin: 0 auto;
    padding: 2rem;
}

/* ─── Tipografía ───────────────────────────────────────────── */
.section-label {
    text-transform: uppercase;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .08em;
    color: #94a3b8;
    margin-bottom: .5rem;
}
h1 { font-size: 2rem; font-weight: 800; color: #0f172a; margin-bottom: 1rem; }
h2 { font-size: 1.4rem; font-weight: 700; color: #0f172a; margin-bottom: .75rem; }
h3 { font-size: 1.05rem; font-weight: 700; color: #0f172a; margin-bottom: .4rem; }
p  { color: #475569; margin-bottom: .75rem; }

/* ─── Secciones ────────────────────────────────────────────── */
section { margin-bottom: 3rem; }
.section-divider {
    border: none;
    border-top: 1px solid #e2e8f0;
    margin: 2.5rem 0;
}

/* ─── Cards ────────────────────────────────────────────────── */
.card {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1.25rem;
}
.card-blue  { border-top: 3px solid #3b82f6; }
.card-green { border-top: 3px solid #22c55e; }
.card-left-blue   { border-left: 4px solid #3b82f6; border-radius: 0 10px 10px 0; }
.card-left-purple { border-left: 4px solid #a855f7; border-radius: 0 10px 10px 0; }
.card-left-amber  { border-left: 4px solid #f59e0b; border-radius: 0 10px 10px 0; }

/* ─── Grids ────────────────────────────────────────────────── */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

/* ─── Badges ───────────────────────────────────────────────── */
.badge {
    display: inline-block;
    font-size: 11px;
    font-weight: 700;
    padding: .2rem .55rem;
    border-radius: 999px;
    margin-left: .5rem;
    vertical-align: middle;
}
.badge-green  { background: #dcfce7; color: #166534; }
.badge-purple { background: #f3e8ff; color: #6b21a8; }
.badge-amber  { background: #fef9c3; color: #854d0e; }

/* ─── Notas / alertas ──────────────────────────────────────── */
.note {
    background: #eff6ff;
    border-left: 4px solid #3b82f6;
    border-radius: 0 8px 8px 0;
    padding: 1rem 1.25rem;
    color: #1e40af;
    font-size: .9rem;
    margin-top: 1rem;
}
.note strong { color: #1d4ed8; }

/* ─── Bloques de código ────────────────────────────────────── */
pre {
    background: #1e1e1e;
    color: #d4d4d4;
    font-family: "Cascadia Code", "Fira Code", "JetBrains Mono", "Consolas", monospace;
    font-size: 13px;
    padding: 1rem;
    border-radius: 8px;
    white-space: pre;
    overflow-x: auto;
    margin: .75rem 0;
    line-height: 1.6;
}
.kw   { color: #569cd6; } /* keyword */
.fn   { color: #dcdcaa; } /* function */
.str  { color: #ce9178; } /* string */
.cmt  { color: #6a9955; } /* comment */
.cls  { color: #4ec9b0; } /* class */
.num  { color: #b5cea8; } /* number */
.var  { color: #9cdcfe; } /* variable */
.pun  { color: #d4d4d4; } /* punctuation */
.tag  { color: #f78c6c; } /* html tag */
.att  { color: #a8ff60; } /* html attribute */
.blade{ color: #c3e88d; } /* blade directive */

/* ─── Nota de código ───────────────────────────────────────── */
.code-note {
    font-size: .8rem;
    color: #64748b;
    margin-top: -.5rem;
    margin-bottom: .75rem;
}

/* ─── Listas ───────────────────────────────────────────────── */
ul.styled { padding-left: 1.25rem; color: #475569; margin: .5rem 0; }
ul.styled li { margin-bottom: .25rem; }

/* ─── Íconos ───────────────────────────────────────────────── */
.icon { font-size: 1.5rem; margin-bottom: .5rem; display: block; }

/* ─── Pasos de flujo ───────────────────────────────────────── */
.step { margin-bottom: 1.25rem; }
.step-header { display: flex; align-items: center; gap: .6rem; margin-bottom: .3rem; }
.step-num {
    width: 28px; height: 28px;
    background: #3b82f6; color: #fff;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: .8rem; font-weight: 700;
    flex-shrink: 0;
}

/* ─── Selector de middleware (pestañas) ───────────────────── */
.tabs { display: flex; gap: .4rem; flex-wrap: wrap; margin-bottom: 1rem; }
.tab-btn {
    background: #e2e8f0;
    border: none;
    border-radius: 6px;
    padding: .4rem .9rem;
    font-family: "Cascadia Code", "Consolas", monospace;
    font-size: .85rem;
    font-weight: 600;
    color: #475569;
    cursor: pointer;
    transition: background .15s, color .15s;
}
.tab-btn.active, .tab-btn:hover {
    background: #3b82f6;
    color: #fff;
}
.tab-panel { display: none; }
.tab-panel.active { display: block; }

/* ─── Cajas resultado (simulación de middleware) ──────────── */
.result-boxes { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-top: .75rem; }
.result-box {
    border-radius: 8px;
    padding: .75rem 1rem;
    font-size: .85rem;
}
.result-ok  { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
.result-err { background: #fff1f2; border: 1px solid #fecdd3; color: #9f1239; }
.result-box strong { display: block; margin-bottom: .2rem; font-size: .9rem; }

/* ─── Matriz de roles ─────────────────────────────────────── */
.role-btns { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
.role-btn {
    border: 2px solid transparent;
    border-radius: 8px;
    padding: .45rem 1.1rem;
    font-weight: 700;
    font-size: .9rem;
    cursor: pointer;
    transition: all .15s;
    background: #f1f5f9;
    color: #475569;
}
.role-btn.active { color: #fff; }

.progress-wrap { margin-bottom: 1.25rem; }
.progress-label { font-size: .85rem; color: #64748b; margin-bottom: .4rem; }
.progress-bar-bg {
    background: #e2e8f0;
    border-radius: 999px;
    height: 10px;
    overflow: hidden;
}
.progress-bar-fill {
    height: 100%;
    border-radius: 999px;
    transition: width .4s ease;
}

.perms-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: .5rem;
}
.perm-item {
    display: flex;
    align-items: center;
    gap: .4rem;
    font-size: .85rem;
    padding: .5rem .65rem;
    border-radius: 6px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
}
.perm-item.has  { border-color: #bbf7d0; background: #f0fdf4; color: #166534; }
.perm-item.no   { opacity: .45; }
.perm-check { font-size: 1rem; }

/* ─── Simulador ────────────────────────────────────────────── */
.sim-container {
    background: #f1f5f9;
    border-radius: 12px;
    padding: 1.25rem;
}
.sim-status {
    display: flex;
    align-items: center;
    gap: .6rem;
    margin-bottom: 1rem;
    font-weight: 600;
    font-size: .95rem;
}
.status-dot {
    width: 11px; height: 11px;
    border-radius: 50%;
    flex-shrink: 0;
    transition: background .3s;
}
.sim-action-btns { display: flex; gap: .5rem; flex-wrap: wrap; margin-bottom: 1rem; }
.sim-btn {
    background: #fff;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    padding: .45rem 1rem;
    font-size: .875rem;
    font-weight: 600;
    color: #334155;
    cursor: pointer;
    transition: background .15s, border-color .15s;
}
.sim-btn:hover { background: #f0f9ff; border-color: #7dd3fc; }
.sim-btn.logout-btn { color: #b91c1c; border-color: #fca5a5; }
.sim-btn.logout-btn:hover { background: #fff1f2; }

.sim-form {
    background: #fff;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    padding: 1.25rem;
    margin-bottom: 1rem;
    display: none;
}
.sim-form.visible { display: block; }
.sim-form h4 { font-size: 1rem; font-weight: 700; margin-bottom: 1rem; color: #0f172a; }
.sim-field { margin-bottom: .75rem; }
.sim-field label { display: block; font-size: .8rem; font-weight: 600; color: #64748b; margin-bottom: .25rem; }
.sim-field input {
    width: 100%;
    padding: .5rem .75rem;
    border: 1px solid #cbd5e1;
    border-radius: 6px;
    font-size: .9rem;
    color: #1e293b;
    background: #f8fafc;
    outline: none;
    transition: border-color .15s;
}
.sim-field input:focus { border-color: #3b82f6; background: #fff; }
.sim-run-btn {
    background: #3b82f6;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: .5rem 1.2rem;
    font-weight: 700;
    font-size: .9rem;
    cursor: pointer;
    margin-top: .25rem;
    transition: background .15s;
}
.sim-run-btn:hover { background: #2563eb; }

.sim-log {
    background: #1e1e1e;
    border-radius: 8px;
    padding: 1rem;
    font-family: "Cascadia Code", "Consolas", monospace;
    font-size: 13px;
    color: #d4d4d4;
    min-height: 2rem;
    display: none;
    line-height: 1.8;
}
.sim-log.visible { display: block; }
.log-line { display: block; opacity: 0; animation: fadein .3s forwards; }
.log-ok  { color: #4ade80; }
.log-email{ color: #60a5fa; }
.log-cmt  { color: #6a9955; }
@keyframes fadein { to { opacity: 1; } }

.sim-user-info {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 8px;
    padding: .75rem 1rem;
    margin-top: .75rem;
    font-size: .9rem;
    color: #166534;
    display: none;
}
.sim-user-info.visible { display: block; }

/* ─── Header de página ─────────────────────────────────────── */
.page-header {
    background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 50%, #2563eb 100%);
    color: #fff;
    padding: 2.5rem 2rem;
    border-radius: 14px;
    margin-bottom: 2.5rem;
}
.page-header .nt-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: .1em;
    text-transform: uppercase;
    opacity: .7;
    margin-bottom: .5rem;
}
.page-header h1 { color: #fff; font-size: 1.9rem; margin-bottom: .5rem; }
.page-header p  { color: rgba(255,255,255,.8); margin: 0; font-size: .95rem; }

/* ─── Responsive ───────────────────────────────────────────── */
@media (max-width: 640px) {
    .page { padding: 1rem; }
    .grid-2 { grid-template-columns: 1fr; }
    .result-boxes { grid-template-columns: 1fr; }
    .perms-grid { grid-template-columns: 1fr 1fr; }
    .page-header { padding: 1.5rem 1rem; }
    .page-header h1 { font-size: 1.4rem; }
}
@media (max-width: 400px) {
    .perms-grid { grid-template-columns: 1fr; }
}
</style>
</head>
<body>

<div class="page">

  <!-- ════════════════════════════════════════════════════════════
       HEADER
  ═══════════════════════════════════════════════════════════════ -->
  <div class="page-header">
    <div class="nt-label">Nota Técnica 6</div>
    <h1>Autenticación y Autorización en Laravel</h1>
    <p>Gestiona quién puede acceder y qué puede hacer dentro de tu aplicación.</p>
  </div>


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 1 — ¿Qué es autenticación y autorización?
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 1</div>
    <h2>¿Qué es la autenticación? ¿Y la autorización?</h2>
    <p>Son dos conceptos distintos que trabajan juntos para proteger una aplicación. La <strong>autenticación</strong> confirma la identidad del usuario; la <strong>autorización</strong> define qué puede hacer una vez dentro. Confundirlos es el error más común en seguridad web.</p>

    <div class="grid-2" style="margin-top:1.25rem;">

      <!-- Card Autenticación -->
      <div class="card card-blue">
        <span class="icon">🔑</span>
        <h3>Autenticación</h3>
        <p style="font-size:.9rem;">Verifica <strong>QUIÉN eres</strong>. Comprueba que el usuario existe y que sus credenciales son correctas antes de dar acceso al sistema.</p>
        <p style="font-size:.85rem;color:#3b82f6;font-weight:600;margin-bottom:.5rem;">Pregunta clave: ¿Eres tú quien dices ser?</p>
        <ul class="styled" style="font-size:.875rem;">
          <li>Login con email y contraseña</li>
          <li>OAuth con Google / GitHub</li>
          <li>Tokens de API (Sanctum / Passport)</li>
          <li>Autenticación de dos factores (2FA)</li>
        </ul>
      </div>

      <!-- Card Autorización -->
      <div class="card card-green">
        <span class="icon">🛡️</span>
        <h3>Autorización</h3>
        <p style="font-size:.9rem;">Verifica <strong>QUÉ PUEDES HACER</strong>. Determina a qué recursos o acciones tiene acceso un usuario ya autenticado.</p>
        <p style="font-size:.85rem;color:#22c55e;font-weight:600;margin-bottom:.5rem;">Pregunta clave: ¿Tienes permiso para esto?</p>
        <ul class="styled" style="font-size:.875rem;">
          <li>Gates (permisos simples con closures)</li>
          <li>Policies (permisos organizados por modelo)</li>
          <li>Roles personalizados</li>
          <li>Middleware <code>can:permiso</code></li>
        </ul>
      </div>

    </div>

    <div class="note" style="margin-top:1rem;">
      <strong>Orden correcto:</strong> Primero se autentica al usuario (<em>¿quién eres?</em>), luego se autoriza cada acción (<em>¿qué puedes hacer?</em>). Son pasos distintos que ocurren en ese orden.
    </div>
  </section>

  <hr class="section-divider">


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 2 — Sistemas de autenticación
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 2</div>
    <h2>¿Cómo implementar autenticación en Laravel?</h2>
    <p>Laravel ofrece tres enfoques según la complejidad del proyecto. Para este curso usaremos <strong>Breeze</strong>, pero es importante conocer las alternativas.</p>

    <!-- Card grande: Breeze -->
    <div class="card card-left-blue" style="margin-bottom:1rem;">
      <div style="display:flex;align-items:center;margin-bottom:.75rem;">
        <h3 style="margin:0;">⚡ Laravel Breeze</h3>
        <span class="badge badge-green">Recomendado para este curso</span>
      </div>
      <p style="font-size:.9rem;">Solución mínima y liviana que incluye: login, registro, recuperación de contraseña, verificación de email y pantalla de perfil. Usa Blade como motor de plantillas y no añade complejidad innecesaria al proyecto.</p>

<pre><span class="cmt"># 1. Instalar Breeze como dependencia de desarrollo</span>
<span class="fn">composer</span> require laravel/breeze --dev

<span class="cmt"># Generar las rutas, controladores y vistas de autenticación</span>
<span class="fn">php</span> artisan breeze:install

<span class="cmt"># 2. Instalar dependencias JS y compilar los assets</span>
<span class="fn">npm</span> install &amp;&amp; npm run dev

<span class="cmt"># 3. Ejecutar migraciones (crea la tabla users y relacionadas)</span>
<span class="fn">php</span> artisan migrate</pre>

      <p class="code-note">Breeze crea automáticamente: rutas de autenticación, controladores, vistas Blade y migraciones de la tabla <code>users</code>.</p>
    </div>

    <div class="grid-2">

      <!-- Card Jetstream -->
      <div class="card card-left-purple">
        <div style="display:flex;align-items:center;margin-bottom:.6rem;">
          <h3 style="margin:0;">🚀 Jetstream</h3>
          <span class="badge badge-purple">Avanzado</span>
        </div>
        <p style="font-size:.875rem;">Solución completa con autenticación de dos factores (2FA), gestión de equipos/organizaciones, tokens de API y sesiones activas.</p>
<pre style="font-size:12px;"><span class="fn">composer</span> require laravel/jetstream
<span class="fn">php</span> artisan jetstream:install livewire
<span class="fn">npm</span> install &amp;&amp; npm run dev
<span class="fn">php</span> artisan migrate</pre>
        <p style="font-size:.8rem;color:#64748b;margin:0;">Ideal para proyectos grandes o con equipos de usuarios.</p>
      </div>

      <!-- Card Auth Manual -->
      <div class="card card-left-amber">
        <div style="display:flex;align-items:center;margin-bottom:.6rem;">
          <h3 style="margin:0;">🔧 Auth Manual</h3>
          <span class="badge badge-amber">Educativo</span>
        </div>
        <p style="font-size:.875rem;">Usando <code>Auth::attempt()</code> directamente. Útil para entender el funcionamiento interno sin scaffolding automático.</p>
<pre style="font-size:12px;"><span class="kw">if</span> (<span class="cls">Auth</span>::<span class="fn">attempt</span>([
    <span class="str">'email'</span> =&gt; <span class="var">$email</span>,
    <span class="str">'password'</span> =&gt; <span class="var">$pass</span>,
])) {
    <span class="var">$request</span>-&gt;<span class="fn">session</span>()
            -&gt;<span class="fn">regenerate</span>();
    <span class="kw">return</span> <span class="fn">redirect</span>(<span class="str">'/dashboard'</span>);
}</pre>
        <p style="font-size:.8rem;color:#64748b;margin:0;">Ideal para entender los cimientos antes de usar scaffolding.</p>
      </div>

    </div>
  </section>

  <hr class="section-divider">


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 3 — Flujo de registro y login
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 3</div>
    <h2>¿Qué ocurre internamente al registrarse?</h2>
    <p>Cada paso del proceso tiene su código correspondiente en Laravel. Desde que el usuario envía el formulario hasta que queda autenticado, suceden 6 etapas.</p>

    <div class="grid-2">
      <!-- Columna izquierda: pasos 1-3 -->
      <div>

        <!-- Paso 1 -->
        <div class="step">
          <div class="step-header">
            <div class="step-num">1</div>
            <h3>Formulario con CSRF</h3>
          </div>
          <p style="font-size:.875rem;">El token <code>@csrf</code> protege contra ataques <em>Cross-Site Request Forgery</em>. Laravel rechaza cualquier POST que no incluya este token válido.</p>
<pre style="font-size:12px;">&lt;<span class="tag">form</span> <span class="att">method</span>=<span class="str">"POST"</span>
      <span class="att">action</span>=<span class="str">"/register"</span>&gt;
  <span class="blade">@csrf</span>
  &lt;<span class="tag">input</span> <span class="att">type</span>=<span class="str">"text"</span>
         <span class="att">name</span>=<span class="str">"name"</span>&gt;
  &lt;<span class="tag">input</span> <span class="att">type</span>=<span class="str">"email"</span>
         <span class="att">name</span>=<span class="str">"email"</span>&gt;
  &lt;<span class="tag">input</span> <span class="att">type</span>=<span class="str">"password"</span>
         <span class="att">name</span>=<span class="str">"password"</span>&gt;
  &lt;<span class="tag">button</span>&gt;Registrarse&lt;/<span class="tag">button</span>&gt;
&lt;/<span class="tag">form</span>&gt;</pre>
        </div>

        <!-- Paso 2 -->
        <div class="step">
          <div class="step-header">
            <div class="step-num">2</div>
            <h3>Validación de datos</h3>
          </div>
          <p style="font-size:.875rem;">Laravel rechaza el request si los datos no cumplen las reglas. La validación falla antes de que el código de negocio se ejecute.</p>
<pre style="font-size:12px;"><span class="var">$request</span>-&gt;<span class="fn">validate</span>([
  <span class="str">'name'</span>     =&gt; <span class="str">'required|string|max:255'</span>,
  <span class="str">'email'</span>    =&gt; <span class="str">'required|email|unique:users'</span>,
  <span class="str">'password'</span> =&gt; <span class="str">'required|min:8|confirmed'</span>,
]);
<span class="cmt">// Si falla, Laravel redirige automáticamente
// con los errores en $errors</span></pre>
        </div>

        <!-- Paso 3 -->
        <div class="step">
          <div class="step-header">
            <div class="step-num">3</div>
            <h3>Hash de contraseña</h3>
          </div>
          <p style="font-size:.875rem;">Las contraseñas <strong>nunca</strong> se guardan en texto plano. El hash bcrypt es irreversible: solo se puede comparar, no descifrar.</p>
<pre style="font-size:12px;"><span class="cmt">// CORRECTO: siempre hashear</span>
<span class="var">$hash</span> = <span class="cls">Hash</span>::<span class="fn">make</span>(<span class="var">$request</span>-&gt;password);
<span class="cmt">// genera: $2y$12$abc123.xyz...</span>

<span class="cmt">// NUNCA hagas esto:</span>
<span class="cmt">// 'password' =&gt; $request-&gt;password</span>
<span class="cmt">// ↑ guarda texto plano — vulnerabilidad crítica</span></pre>
        </div>

      </div>

      <!-- Columna derecha: pasos 4-6 -->
      <div>

        <!-- Paso 4 -->
        <div class="step">
          <div class="step-header">
            <div class="step-num">4</div>
            <h3>Guardar en base de datos</h3>
          </div>
          <p style="font-size:.875rem;">Eloquent inserta el nuevo registro en la tabla <code>users</code>. El modelo User maneja automáticamente el fillable y timestamps.</p>
<pre style="font-size:12px;"><span class="var">$user</span> = <span class="cls">User</span>::<span class="fn">create</span>([
  <span class="str">'name'</span>     =&gt; <span class="var">$request</span>-&gt;name,
  <span class="str">'email'</span>    =&gt; <span class="var">$request</span>-&gt;email,
  <span class="str">'password'</span> =&gt; <span class="cls">Hash</span>::<span class="fn">make</span>(
                  <span class="var">$request</span>-&gt;password
                ),
]);
<span class="cmt">// INSERT INTO users ...</span></pre>
        </div>

        <!-- Paso 5 -->
        <div class="step">
          <div class="step-header">
            <div class="step-num">5</div>
            <h3>Iniciar sesión</h3>
          </div>
          <p style="font-size:.875rem;">Se crea la sesión del usuario en el servidor. <code>session()->regenerate()</code> previene ataques de fijación de sesión.</p>
<pre style="font-size:12px;"><span class="cmt">// Opción A: login directo tras registro</span>
<span class="cls">Auth</span>::<span class="fn">login</span>(<span class="var">$user</span>);

<span class="cmt">// Opción B: con credenciales (en login)</span>
<span class="cls">Auth</span>::<span class="fn">attempt</span>([
  <span class="str">'email'</span>    =&gt; <span class="var">$email</span>,
  <span class="str">'password'</span> =&gt; <span class="var">$pass</span>,
]);

<span class="cmt">// Siempre regenerar el session ID</span>
<span class="var">$request</span>-&gt;<span class="fn">session</span>()-&gt;<span class="fn">regenerate</span>();</pre>
        </div>

        <!-- Paso 6 -->
        <div class="step">
          <div class="step-header">
            <div class="step-num">6</div>
            <h3>Redirigir al destino</h3>
          </div>
          <p style="font-size:.875rem;"><code>intended()</code> recuerda la ruta que el usuario intentó visitar antes del login. Si no hay ninguna, usa el fallback.</p>
<pre style="font-size:12px;"><span class="cmt">// Redirige a la ruta original o a /dashboard</span>
<span class="kw">return</span> <span class="fn">redirect</span>()-&gt;<span class="fn">intended</span>(<span class="str">'/dashboard'</span>);

<span class="cmt">// En Blade: bloques condicionales de sesión</span>
<span class="blade">@auth</span>
  &lt;<span class="tag">p</span>&gt;Hola, {{ <span class="fn">Auth</span>::<span class="fn">user</span>()-&gt;name }}&lt;/<span class="tag">p</span>&gt;
<span class="blade">@endauth</span>

<span class="blade">@guest</span>
  &lt;<span class="tag">a</span> <span class="att">href</span>=<span class="str">"/login"</span>&gt;Iniciar sesión&lt;/<span class="tag">a</span>&gt;
<span class="blade">@endguest</span></pre>
        </div>

      </div>
    </div>
  </section>

  <hr class="section-divider">


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 4 — Middleware (INTERACTIVO)
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 4 · Interactivo</div>
    <h2>Middleware de autenticación</h2>
    <p>El middleware es código que se ejecuta <strong>antes</strong> de que la petición llegue al controlador. Actúa como el "portero" de las rutas: decide si la petición puede continuar o debe ser rechazada. Se pueden encadenar múltiples middlewares en una misma ruta.</p>

<pre><span class="cmt">// Ejemplo: múltiples middlewares encadenados</span>
<span class="cls">Route</span>::<span class="fn">middleware</span>([<span class="str">'auth'</span>, <span class="str">'verified'</span>, <span class="str">'can:ver-admin'</span>])
    -&gt;<span class="fn">group</span>(<span class="kw">function</span>() {
        <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/admin'</span>, [<span class="cls">AdminController</span>::<span class="kw">class</span>, <span class="str">'index'</span>]);
    });
<span class="cmt">// Cada middleware se ejecuta en orden: auth → verified → can:ver-admin</span></pre>

    <p style="margin-top:1rem;margin-bottom:.75rem;">Selecciona un middleware para ver su descripción y comportamiento:</p>

    <!-- Pestañas -->
    <div class="tabs" role="tablist">
      <button class="tab-btn active" onclick="mw(0)" role="tab">auth</button>
      <button class="tab-btn"        onclick="mw(1)" role="tab">guest</button>
      <button class="tab-btn"        onclick="mw(2)" role="tab">verified</button>
      <button class="tab-btn"        onclick="mw(3)" role="tab">can:permiso</button>
    </div>

    <!-- Panel: auth -->
    <div id="mw-panel-0" class="tab-panel active">
      <div class="card">
        <p><code><strong>auth</strong></code> — Verifica que el usuario tiene una sesión activa (está autenticado). Es el middleware más básico e imprescindible para proteger rutas privadas.</p>
<pre><span class="cmt">// Forma 1: en la definición de la ruta</span>
<span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/dashboard'</span>, <span class="fn">fn</span>() =&gt; <span class="fn">view</span>(<span class="str">'dashboard'</span>))
    -&gt;<span class="fn">middleware</span>(<span class="str">'auth'</span>);

<span class="cmt">// Forma 2: en el constructor del controlador</span>
<span class="kw">public function</span> <span class="fn">__construct</span>()
{
    <span class="var">$this</span>-&gt;<span class="fn">middleware</span>(<span class="str">'auth'</span>);
}

<span class="cmt">// Forma 3: proteger grupo completo de rutas</span>
<span class="cls">Route</span>::<span class="fn">middleware</span>(<span class="str">'auth'</span>)-&gt;<span class="fn">group</span>(<span class="kw">function</span>() {
    <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/perfil'</span>, [<span class="cls">UserController</span>::<span class="kw">class</span>, <span class="str">'show'</span>]);
    <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/config'</span>, [<span class="cls">ConfigController</span>::<span class="kw">class</span>, <span class="str">'edit'</span>]);
});</pre>
        <div class="result-boxes">
          <div class="result-box result-ok">
            <strong>✅ Sesión activa</strong>
            El usuario ya inició sesión. Laravel deja pasar la petición al controlador normalmente.
          </div>
          <div class="result-box result-err">
            <strong>❌ Sin sesión</strong>
            Laravel redirige automáticamente a <code>/login</code> y guarda la URL original para volver después del login.
          </div>
        </div>
      </div>
    </div>

    <!-- Panel: guest -->
    <div id="mw-panel-1" class="tab-panel">
      <div class="card">
        <p><code><strong>guest</strong></code> — El opuesto de <code>auth</code>. Solo permite el acceso a usuarios <strong>no autenticados</strong>. Usado para las páginas de login y registro: si ya iniciaste sesión, no tiene sentido mostrártelas.</p>
<pre><span class="cmt">// Solo usuarios SIN sesión pueden ver estas rutas</span>
<span class="cls">Route</span>::<span class="fn">middleware</span>(<span class="str">'guest'</span>)-&gt;<span class="fn">group</span>(<span class="kw">function</span>() {
    <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/login'</span>,    [<span class="cls">AuthController</span>::<span class="kw">class</span>, <span class="str">'loginForm'</span>]);
    <span class="cls">Route</span>::<span class="fn">post</span>(<span class="str">'/login'</span>,   [<span class="cls">AuthController</span>::<span class="kw">class</span>, <span class="str">'login'</span>]);
    <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/register'</span>, [<span class="cls">AuthController</span>::<span class="kw">class</span>, <span class="str">'registerForm'</span>]);
    <span class="cls">Route</span>::<span class="fn">post</span>(<span class="str">'/register'</span>,[<span class="cls">AuthController</span>::<span class="kw">class</span>, <span class="str">'register'</span>]);
});</pre>
        <div class="result-boxes">
          <div class="result-box result-ok">
            <strong>✅ Usuario invitado</strong>
            No hay sesión activa. Laravel muestra la página de login o registro normalmente.
          </div>
          <div class="result-box result-err">
            <strong>❌ Ya autenticado</strong>
            Laravel redirige al usuario a <code>/dashboard</code> (o la ruta configurada en <code>RedirectIfAuthenticated</code>).
          </div>
        </div>
      </div>
    </div>

    <!-- Panel: verified -->
    <div id="mw-panel-2" class="tab-panel">
      <div class="card">
        <p><code><strong>verified</strong></code> — Verifica que el usuario autenticado ha confirmado su dirección de email. Requiere que el modelo <code>User</code> implemente <code>MustVerifyEmail</code>. Útil para rutas sensibles que requieren email verificado.</p>
<pre><span class="cmt">// El modelo User debe implementar MustVerifyEmail</span>
<span class="kw">class</span> <span class="cls">User</span> <span class="kw">extends</span> <span class="cls">Authenticatable</span>
    <span class="kw">implements</span> <span class="cls">MustVerifyEmail</span>
{
    <span class="cmt">// ...</span>
}

<span class="cmt">// Rutas que requieren email verificado</span>
<span class="cls">Route</span>::<span class="fn">middleware</span>([<span class="str">'auth'</span>, <span class="str">'verified'</span>])
    -&gt;<span class="fn">group</span>(<span class="kw">function</span>() {
        <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/checkout'</span>, [<span class="cls">OrderController</span>::<span class="kw">class</span>, <span class="str">'checkout'</span>]);
        <span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/factura'</span>,  [<span class="cls">InvoiceController</span>::<span class="kw">class</span>, <span class="str">'index'</span>]);
    });</pre>
        <div class="result-boxes">
          <div class="result-box result-ok">
            <strong>✅ Email verificado</strong>
            El usuario hizo clic en el enlace de confirmación. Acceso permitido a la ruta protegida.
          </div>
          <div class="result-box result-err">
            <strong>❌ Sin verificar</strong>
            Laravel redirige a <code>/email/verify</code> mostrando un aviso para reenviar el correo de verificación.
          </div>
        </div>
      </div>
    </div>

    <!-- Panel: can:permiso -->
    <div id="mw-panel-3" class="tab-panel">
      <div class="card">
        <p><code><strong>can:permiso</strong></code> — Integra el sistema de Gates y Policies directamente en las rutas. Comprueba si el usuario autenticado tiene un permiso específico antes de ejecutar el controlador.</p>
<pre><span class="cmt">// Requiere el Gate 'editar-posts' definido en AuthServiceProvider</span>
<span class="cls">Route</span>::<span class="fn">get</span>(<span class="str">'/posts/{post}/edit'</span>, [<span class="cls">PostController</span>::<span class="kw">class</span>, <span class="str">'edit'</span>])
    -&gt;<span class="fn">middleware</span>(<span class="str">'can:editar-posts'</span>);

<span class="cmt">// Con parámetro de modelo: usa la Policy automáticamente</span>
<span class="cls">Route</span>::<span class="fn">put</span>(<span class="str">'/posts/{post}'</span>, [<span class="cls">PostController</span>::<span class="kw">class</span>, <span class="str">'update'</span>])
    -&gt;<span class="fn">middleware</span>(<span class="str">'can:update,post'</span>);

<span class="cmt">// Definición del Gate correspondiente</span>
<span class="cls">Gate</span>::<span class="fn">define</span>(<span class="str">'editar-posts'</span>, <span class="kw">function</span>(<span class="cls">User</span> <span class="var">$user</span>) {
    <span class="kw">return</span> <span class="fn">in_array</span>(<span class="var">$user</span>-&gt;role, [<span class="str">'admin'</span>, <span class="str">'editor'</span>]);
});</pre>
        <div class="result-boxes">
          <div class="result-box result-ok">
            <strong>✅ Tiene el permiso</strong>
            El Gate o Policy devuelve <code>true</code>. La petición llega al controlador normalmente.
          </div>
          <div class="result-box result-err">
            <strong>❌ Sin permiso</strong>
            Laravel devuelve una respuesta HTTP <code>403 Forbidden</code>. El controlador nunca se ejecuta.
          </div>
        </div>
      </div>
    </div>

  </section>

  <hr class="section-divider">


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 5 — Gates y Policies
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 5</div>
    <h2>Autorización con Gates y Policies</h2>
    <p>Los dos mecanismos de autorización de Laravel para controlar qué acciones puede realizar cada usuario autenticado. Se complementan: Gates para lógica simple, Policies para lógica organizada por modelo.</p>

    <div class="grid-2">

      <!-- Card Gates -->
      <div class="card">
        <h3>🚪 Gates</h3>
        <p style="font-size:.875rem;">Funciones simples (closures) definidas en <code>AuthServiceProvider</code>. Ideales para permisos que <strong>no dependen de un modelo específico</strong> o son transversales a la aplicación.</p>
<pre style="font-size:12px;"><span class="cmt">// En AuthServiceProvider → boot()</span>
<span class="cls">Gate</span>::<span class="fn">define</span>(<span class="str">'ver-admin'</span>,
  <span class="kw">function</span>(<span class="cls">User</span> <span class="var">$user</span>) {
    <span class="kw">return</span> <span class="var">$user</span>-&gt;role === <span class="str">'admin'</span>;
  }
);

<span class="cmt">// En el controlador</span>
<span class="kw">if</span> (<span class="cls">Gate</span>::<span class="fn">denies</span>(<span class="str">'ver-admin'</span>)) {
  <span class="fn">abort</span>(<span class="num">403</span>, <span class="str">'Sin acceso'</span>);
}

<span class="cmt">// En Blade</span>
<span class="blade">@can</span>(<span class="str">'ver-admin'</span>)
  &lt;<span class="tag">a</span>&gt;Panel Admin&lt;/<span class="tag">a</span>&gt;
<span class="blade">@endcan</span></pre>
      </div>

      <!-- Card Policies -->
      <div class="card">
        <h3>📋 Policies</h3>
        <p style="font-size:.875rem;">Clases organizadas por modelo. Agrupan todos los permisos relacionados a un modelo (ej: <code>PostPolicy</code> maneja todos los permisos de <code>Post</code>). Más ordenado para proyectos grandes.</p>
<pre style="font-size:12px;"><span class="cmt"># Crear la policy con Artisan</span>
<span class="fn">php</span> artisan make:policy PostPolicy
                        --model=Post

<span class="cmt">// Método en PostPolicy.php</span>
<span class="kw">public function</span> <span class="fn">update</span>(
  <span class="cls">User</span> <span class="var">$user</span>, <span class="cls">Post</span> <span class="var">$post</span>
): <span class="kw">bool</span> {
  <span class="kw">return</span> <span class="var">$user</span>-&gt;id === <span class="var">$post</span>-&gt;user_id;
}

<span class="cmt">// En el controlador</span>
<span class="var">$this</span>-&gt;<span class="fn">authorize</span>(<span class="str">'update'</span>, <span class="var">$post</span>);
<span class="cmt">// ↑ lanza 403 si no tiene permiso</span></pre>
      </div>

    </div>
  </section>

  <hr class="section-divider">


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 6 — Roles y permisos (INTERACTIVO)
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 6 · Interactivo</div>
    <h2>Matriz de roles y permisos</h2>
    <p>Los roles agrupan permisos y se asignan a usuarios. Al verificar un permiso, Laravel comprueba el rol del usuario y determina si tiene acceso a la acción solicitada. Selecciona un rol para ver sus permisos:</p>

    <!-- Botones de rol -->
    <div class="role-btns" role="group">
      <button class="role-btn active" id="rbtn-0" onclick="rol(0)">Administrador</button>
      <button class="role-btn"        id="rbtn-1" onclick="rol(1)">Editor</button>
      <button class="role-btn"        id="rbtn-2" onclick="rol(2)">Usuario</button>
      <button class="role-btn"        id="rbtn-3" onclick="rol(3)">Invitado</button>
    </div>

    <!-- Panel del rol -->
    <div class="card" id="rol-panel">
      <h3 id="rol-name" style="margin-bottom:.75rem;"></h3>

      <!-- Barra de progreso -->
      <div class="progress-wrap">
        <div class="progress-label" id="rol-progress-label"></div>
        <div class="progress-bar-bg">
          <div class="progress-bar-fill" id="rol-bar"></div>
        </div>
      </div>

      <!-- Grilla de permisos -->
      <div class="perms-grid" id="perms-grid"></div>
    </div>
  </section>

  <hr class="section-divider">


  <!-- ════════════════════════════════════════════════════════════
       SECCIÓN 7 — SIMULADOR
  ═══════════════════════════════════════════════════════════════ -->
  <section>
    <div class="section-label">Sección 7 · Simulador</div>
    <h2>Simulador de autenticación</h2>
    <p>Ahora que conoces toda la teoría, simula el proceso completo. Elige una acción y observa qué ocurre internamente en Laravel paso a paso.</p>

    <div class="sim-container">

      <!-- Estado del usuario -->
      <div class="sim-status">
        <div class="status-dot" id="status-dot" style="background:#ef4444;"></div>
        <span id="status-text">Estado: Invitado (sin sesión)</span>
      </div>

      <!-- Info del usuario autenticado -->
      <div class="sim-user-info" id="sim-user-info">
        <strong id="sim-user-name"></strong>
        <span id="sim-user-email" style="font-size:.85rem;opacity:.8;"></span>
      </div>

      <!-- Botones de acción -->
      <div class="sim-action-btns">
        <button class="sim-btn" onclick="showForm('register')">📝 Registrarse</button>
        <button class="sim-btn" onclick="showForm('login')">🔐 Iniciar sesión</button>
        <button class="sim-btn" onclick="showForm('recover')">🔑 Recuperar contraseña</button>
        <button class="sim-btn logout-btn" id="logout-btn" style="display:none;" onclick="doLogout()">🚪 Cerrar sesión</button>
      </div>

      <!-- Formulario de registro -->
      <div class="sim-form" id="form-register">
        <h4>📝 Formulario de registro</h4>
        <div class="sim-field">
          <label>Nombre completo</label>
          <input type="text" id="reg-name" placeholder="Ej: María García" value="María García">
        </div>
        <div class="sim-field">
          <label>Email</label>
          <input type="email" id="reg-email" placeholder="Ej: maria@ejemplo.com" value="maria@ejemplo.com">
        </div>
        <div class="sim-field">
          <label>Contraseña</label>
          <input type="password" id="reg-pass" placeholder="Mínimo 8 caracteres" value="secreta123">
        </div>
        <div class="sim-field">
          <label>Confirmar contraseña</label>
          <input type="password" placeholder="Repite la contraseña" value="secreta123">
        </div>
        <button class="sim-run-btn" onclick="runSim('register')">⚡ Simular registro</button>
      </div>

      <!-- Formulario de login -->
      <div class="sim-form" id="form-login">
        <h4>🔐 Formulario de inicio de sesión</h4>
        <div class="sim-field">
          <label>Email</label>
          <input type="email" id="login-email" placeholder="Ej: maria@ejemplo.com" value="maria@ejemplo.com">
        </div>
        <div class="sim-field">
          <label>Contraseña</label>
          <input type="password" id="login-pass" placeholder="Tu contraseña" value="secreta123">
        </div>
        <button class="sim-run-btn" onclick="runSim('login')">⚡ Simular login</button>
      </div>

      <!-- Formulario de recuperación -->
      <div class="sim-form" id="form-recover">
        <h4>🔑 Recuperación de contraseña</h4>
        <div class="sim-field">
          <label>Email registrado</label>
          <input type="email" id="recover-email" placeholder="Ej: maria@ejemplo.com" value="maria@ejemplo.com">
        </div>
        <button class="sim-run-btn" onclick="runSim('recover')">⚡ Simular recuperación</button>
      </div>

      <!-- Log de animación -->
      <div class="sim-log" id="sim-log"></div>

    </div>
  </section>

</div><!-- /page -->


<!-- ════════════════════════════════════════════════════════════
     JAVASCRIPT
═══════════════════════════════════════════════════════════════ -->
<script>
// ─────────────────────────────────────────────────────────────
// 1. SELECTOR DE MIDDLEWARE
//    Muestra/oculta el panel correspondiente y resalta la pestaña.
// ─────────────────────────────────────────────────────────────
function mw(index) {
  // Ocultar todos los paneles y desactivar todas las pestañas
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));

  // Mostrar el panel elegido y marcar la pestaña como activa
  document.getElementById('mw-panel-' + index).classList.add('active');
  document.querySelectorAll('.tab-btn')[index].classList.add('active');
}


// ─────────────────────────────────────────────────────────────
// 2. SELECTOR DE ROLES
//    Actualiza la barra de progreso y regenera la grilla de permisos.
// ─────────────────────────────────────────────────────────────

// Lista completa de los 11 permisos del sistema
var PERMISOS = [
  'Ver usuarios',
  'Crear usuarios',
  'Editar usuarios',
  'Eliminar usuarios',
  'Ver reportes',
  'Configurar sistema',
  'Crear contenido',
  'Editar contenido',
  'Ver contenido',
  'Editar perfil propio',
  'Ver contenido público'
];

// Definición de los 4 roles con sus colores y permisos
var ROLES = [
  {
    nombre: '👑 Administrador',
    color: '#ef4444',
    // El admin tiene todos los permisos (índices 0-10)
    permisos: [0,1,2,3,4,5,6,7,8,9,10]
  },
  {
    nombre: '✏️ Editor',
    color: '#f59e0b',
    // Editor: ver usuarios, crear/editar contenido, ver reportes,
    //         ver contenido, editar perfil propio, ver público
    permisos: [0,4,6,7,8,9,10]
  },
  {
    nombre: '👤 Usuario',
    color: '#22c55e',
    // Usuario básico: solo ver contenido, editar su perfil, ver público
    permisos: [8,9,10]
  },
  {
    nombre: '👁️ Invitado',
    color: '#6b7280',
    // Invitado: solo puede ver contenido público, sin login
    permisos: [10]
  }
];

function rol(index) {
  var rolData   = ROLES[index];
  var total     = PERMISOS.length;          // siempre 11
  var tiene     = rolData.permisos.length;
  var porcentaje = Math.round((tiene / total) * 100);

  // Actualizar botones: quitar clase active de todos, añadir al elegido
  for (var i = 0; i < 4; i++) {
    var btn = document.getElementById('rbtn-' + i);
    btn.classList.remove('active');
    btn.style.background = '';
    btn.style.borderColor = '';
    btn.style.color = '';
  }
  var btnActivo = document.getElementById('rbtn-' + index);
  btnActivo.classList.add('active');
  btnActivo.style.background   = rolData.color;
  btnActivo.style.borderColor  = rolData.color;
  btnActivo.style.color        = '#fff';

  // Actualizar nombre del rol
  document.getElementById('rol-name').textContent = rolData.nombre;

  // Actualizar etiqueta de progreso
  document.getElementById('rol-progress-label').textContent =
    tiene + ' de ' + total + ' permisos (' + porcentaje + '%)';

  // Actualizar barra de progreso (color dinámico del rol)
  var bar = document.getElementById('rol-bar');
  bar.style.width      = porcentaje + '%';
  bar.style.background = rolData.color;

  // Regenerar la grilla de permisos
  var grid = document.getElementById('perms-grid');
  grid.innerHTML = ''; // limpiar contenido anterior

  PERMISOS.forEach(function(permiso, i) {
    var tienePermiso = rolData.permisos.indexOf(i) !== -1;
    var item = document.createElement('div');
    item.className = 'perm-item ' + (tienePermiso ? 'has' : 'no');
    item.innerHTML =
      '<span class="perm-check">' + (tienePermiso ? '✓' : '✗') + '</span>' +
      '<span>' + permiso + '</span>';
    grid.appendChild(item);
  });
}

// Inicializar con "Administrador" seleccionado al cargar la página
rol(0);


// ─────────────────────────────────────────────────────────────
// 3. SIMULADOR DE AUTENTICACIÓN
//    Muestra formularios y anima logs paso a paso con setTimeout.
// ─────────────────────────────────────────────────────────────

// Estado interno del simulador
var simState = {
  autenticado: false,
  nombre: '',
  email: ''
};

// Muestra el formulario correspondiente al modo elegido
function showForm(mode) {
  // Ocultar todos los formularios primero
  document.getElementById('form-register').classList.remove('visible');
  document.getElementById('form-login').classList.remove('visible');
  document.getElementById('form-recover').classList.remove('visible');

  // Limpiar el log de la simulación anterior
  var logEl = document.getElementById('sim-log');
  logEl.innerHTML = '';
  logEl.classList.remove('visible');

  // Mostrar el formulario del modo seleccionado
  document.getElementById('form-' + mode).classList.add('visible');
}

// Ejecuta la animación del simulador según el modo
function runSim(mode) {
  var logEl = document.getElementById('sim-log');
  logEl.innerHTML = '';
  logEl.classList.add('visible');

  // Definir las líneas de log según el modo
  var lines = [];
  var email = '';

  if (mode === 'register') {
    var nombre = document.getElementById('reg-name').value || 'Usuario';
    email = document.getElementById('reg-email').value || 'usuario@ejemplo.com';
    lines = [
      { txt: '→ Petición POST /register recibida...',            cls: '' },
      { txt: '→ Validando campos del formulario...',             cls: '' },
      { txt: '→ Email único verificado en tabla users...',       cls: '' },
      { txt: '→ Contraseña hasheada con bcrypt ($2y$12$...)...', cls: '' },
      { txt: '→ Usuario insertado en base de datos (id: 42)',    cls: '' },
      { txt: '→ Auth::login($user) — sesión creada',            cls: '' },
      { txt: '→ Session ID regenerado por seguridad',           cls: '' },
      { txt: '✅ Registro exitoso — redirigiendo a /dashboard',  cls: 'log-ok' }
    ];
    // Al terminar: autenticar en el simulador
    window._simAfter = function() {
      setAutenticado(true, nombre, email);
    };

  } else if (mode === 'login') {
    email = document.getElementById('login-email').value || 'usuario@ejemplo.com';
    lines = [
      { txt: '→ Petición POST /login recibida...',                      cls: '' },
      { txt: '→ Buscando usuario por email en base de datos...',        cls: '' },
      { txt: '→ Auth::attempt() — verificando contraseña con bcrypt...', cls: '' },
      { txt: '→ Credenciales válidas confirmadas',                      cls: '' },
      { txt: '→ Sesión iniciada — session()->regenerate()',             cls: '' },
      { txt: '✅ Login exitoso — redirigiendo a /dashboard',            cls: 'log-ok' }
    ];
    window._simAfter = function() {
      setAutenticado(true, 'Usuario', email);
    };

  } else if (mode === 'recover') {
    email = document.getElementById('recover-email').value || 'usuario@ejemplo.com';
    lines = [
      { txt: '→ Petición POST /forgot-password recibida...',            cls: '' },
      { txt: '→ Verificando que el email existe en users...',           cls: '' },
      { txt: '→ Generando token único de recuperación...',             cls: '' },
      { txt: '→ Token almacenado en tabla password_resets...',         cls: '' },
      { txt: '→ Enviando email con enlace de recuperación...',         cls: '' },
      { txt: '📧 Email enviado a ' + email,                            cls: 'log-email' },
      { txt: '// El enlace expira en 60 minutos',                      cls: 'log-cmt' }
    ];
    // Recuperar contraseña no inicia sesión
    window._simAfter = function() {};
  }

  // Animar las líneas una por una con un delay de 400ms entre cada una
  lines.forEach(function(line, i) {
    setTimeout(function() {
      var span = document.createElement('span');
      span.className = 'log-line ' + line.cls;
      span.textContent = line.txt;
      logEl.appendChild(span);

      // Al terminar la última línea, ejecutar la acción posterior
      if (i === lines.length - 1) {
        setTimeout(function() {
          if (window._simAfter) window._simAfter();
        }, 300);
      }
    }, i * 400); // 400ms de intervalo entre cada línea
  });
}

// Actualiza el estado visual del usuario en el simulador
function setAutenticado(estado, nombre, email) {
  simState.autenticado = estado;
  simState.nombre = nombre;
  simState.email  = email;

  var dot      = document.getElementById('status-dot');
  var txt      = document.getElementById('status-text');
  var info     = document.getElementById('sim-user-info');
  var logoutBtn = document.getElementById('logout-btn');

  if (estado) {
    // Estado autenticado: punto verde, mostrar datos del usuario
    dot.style.background = '#22c55e';
    txt.textContent = 'Estado: Autenticado ✅';
    document.getElementById('sim-user-name').textContent  = '👤 ' + nombre;
    document.getElementById('sim-user-email').textContent = email;
    info.classList.add('visible');
    logoutBtn.style.display = 'inline-block';
  } else {
    // Estado invitado: punto rojo, ocultar datos
    dot.style.background = '#ef4444';
    txt.textContent = 'Estado: Invitado (sin sesión)';
    info.classList.remove('visible');
    logoutBtn.style.display = 'none';
  }
}

// Maneja el cierre de sesión del simulador
function doLogout() {
  // Ocultar formularios y limpiar el log
  document.getElementById('form-register').classList.remove('visible');
  document.getElementById('form-login').classList.remove('visible');
  document.getElementById('form-recover').classList.remove('visible');

  var logEl = document.getElementById('sim-log');
  logEl.innerHTML = '';
  logEl.classList.add('visible');

  // Animar el proceso de logout
  var logoutLines = [
    { txt: '→ Petición POST /logout recibida...', cls: '' },
    { txt: '→ Auth::logout() — sesión destruida', cls: '' },
    { txt: '→ Session ID invalidado',             cls: '' },
    { txt: '→ Cookie de sesión eliminada',        cls: '' },
    { txt: '✅ Sesión cerrada — redirigiendo a /', cls: 'log-ok' }
  ];

  logoutLines.forEach(function(line, i) {
    setTimeout(function() {
      var span = document.createElement('span');
      span.className = 'log-line ' + line.cls;
      span.textContent = line.txt;
      logEl.appendChild(span);

      // Al terminar, volver al estado de invitado
      if (i === logoutLines.length - 1) {
        setTimeout(function() {
          setAutenticado(false, '', '');
          // Limpiar el log después de un momento
          setTimeout(function() {
            logEl.classList.remove('visible');
            logEl.innerHTML = '';
          }, 1500);
        }, 400);
      }
    }, i * 400);
  });
}
</script>

</body>
</html>
