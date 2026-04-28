<div class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4"
     style="font-family: 'Inter', system-ui, -apple-system, sans-serif; background: rgba(8, 12, 24, 0.75); backdrop-filter: blur(6px);">

    <div class="relative w-full max-w-[720px] my-8">

        <div class="relative bg-white w-full overflow-hidden" style="border-radius:24px; box-shadow:0 32px 80px rgba(0,0,0,0.22);">

            {{-- Franja superior animada --}}
            <div style="height:4px; background:linear-gradient(90deg,#f59e0b,#ea580c,#f59e0b); background-size:200% 100%; animation:shimmer 3s linear infinite;"></div>

            {{-- Botón cerrar --}}
            <a href="{{ route('home') }}"
               style="position:absolute; top:20px; right:20px; width:34px; height:34px; border-radius:50%; background:#f8fafc; border:1px solid #e2e8f0; display:flex; align-items:center; justify-content:center; color:#94a3b8; text-decoration:none;"
               onmouseover="this.style.background='#f1f5f9'; this.style.color='#475569';"
               onmouseout="this.style.background='#f8fafc'; this.style.color='#94a3b8';">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
                    <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
                </svg>
            </a>

            <div style="padding: 40px 44px 44px;">

                {{-- Header --}}
                <div style="margin-bottom:28px;">
                    <div style="display:flex; align-items:center; gap:12px; margin-bottom:10px;">
                        <div style="width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,#fef3c7,#fde68a); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                            </svg>
                        </div>
                        <h2 style="font-size:20px; font-weight:800; color:#0f172a; letter-spacing:-0.03em; margin:0;">
                            Buscador de atleta
                        </h2>
                    </div>
                    <p style="font-size:15px; color:#64748b; line-height:1.6; margin:0 0 0 52px;">
                        Ingresá el nombre o el DNI para verificar el estado actual y los datos de inscripción.
                    </p>
                </div>

                {{-- Formulario --}}
                <form wire:submit.prevent="performSearch" style="margin-bottom:28px;">
                    <div style="position:relative;">
                        <div style="position:absolute; inset:-3px; border-radius:20px; background:linear-gradient(90deg,#fbbf24,#f97316,#fbbf24); filter:blur(7px); opacity:0.45; pointer-events:none;"></div>

                        <div style="position:relative; background:#fff; border-radius:16px; display:flex; align-items:center; border:2px solid #fde68a;">
                            <span style="position:absolute; left:18px; color:#f59e0b; display:flex; pointer-events:none;">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                                </svg>
                            </span>

                            <input wire:model.defer="search"
                                   type="text"
                                   placeholder="Ingresá nombre o DNI..."
                                   autocomplete="off"
                                   style="width:100%; padding:17px 60px 17px 50px; border:none; outline:none; font-size:16px; font-weight:500; color:#0f172a; background:transparent; font-family:inherit; letter-spacing:-0.01em;">

                            <button type="submit"
                                    style="position:absolute; right:10px; width:40px; height:40px; border-radius:12px; background:linear-gradient(135deg,#f59e0b,#ea580c); border:none; cursor:pointer; display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 2px 8px rgba(234,88,12,0.35);">
                                <svg wire:loading.remove wire:target="performSearch" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                                </svg>
                                <svg wire:loading wire:target="performSearch" class="animate-spin" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5">
                                    <circle cx="12" cy="12" r="10" stroke-opacity="0.3"/><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @error('search')
                        <p style="font-size:13px; color:#ef4444; margin:10px 0 0 4px; display:flex; align-items:center; gap:5px; font-weight:500;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </form>

                {{-- Resultados --}}
                <div>
                    @if(!$searched)
                        {{-- vacío inicial --}}

                    @elseif($athlete)
                        <div style="display:flex; flex-direction:column; gap:16px;">

                            {{-- Card atleta --}}
                            <div style="border:1.5px solid #e2e8f0; border-radius:18px; overflow:hidden; background:#fff;">

                                {{-- Label de sección --}}
                                <div style="padding:14px 22px; background:#f8fafc; border-bottom:1.5px solid #e2e8f0; display:flex; align-items:center; gap:10px;">
                                    <div style="width:32px; height:32px; border-radius:9px; background:linear-gradient(135deg,#fef3c7,#fed7aa); display:flex; align-items:center; justify-content:center;">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
                                        </svg>
                                    </div>
                                    <span style="font-size:11px; font-weight:700; color:#94a3b8; letter-spacing:0.1em; text-transform:uppercase;">Datos del atleta</span>
                                </div>

                                {{-- Avatar + nombre --}}
                                <div style="padding:22px 24px; display:flex; align-items:center; gap:16px; border-bottom:1.5px solid #f1f5f9;">
                                    <div style="width:52px; height:52px; border-radius:15px; background:linear-gradient(135deg,#f59e0b,#ea580c); display:flex; align-items:center; justify-content:center; flex-shrink:0; box-shadow:0 4px 12px rgba(234,88,12,0.25);">
                                        <span style="font-size:18px; font-weight:800; color:#fff; letter-spacing:-0.02em;">
                                            {{ strtoupper(substr($athlete->name, 0, 1)) }}{{ strtoupper(substr($athlete->last_name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p style="font-size:20px; font-weight:800; color:#0f172a; margin:0; letter-spacing:-0.03em; line-height:1.2;">
                                            {{ $athlete->name }} {{ $athlete->last_name }}
                                        </p>
                                        <p style="font-size:13px; color:#94a3b8; margin:4px 0 0; font-weight:500;">
                                            DNI {{ $athlete->identity_document }}
                                        </p>
                                    </div>
                                </div>

                                {{-- Grid 2×2 --}}
                                <div style="display:grid; grid-template-columns:1fr 1fr;">

                                    <div style="padding:20px 24px; border-right:1.5px solid #f1f5f9; border-bottom:1.5px solid #f1f5f9;">
                                        <p style="font-size:10px; font-weight:700; color:#b0bec5; letter-spacing:0.1em; text-transform:uppercase; margin:0 0 7px;">Email</p>
                                        <p style="font-size:15px; font-weight:600; color:#1e293b; margin:0;">{{ $athlete->email ?: 'No especificado' }}</p>
                                    </div>

                                    <div style="padding:20px 24px; border-bottom:1.5px solid #f1f5f9;">
                                        <p style="font-size:10px; font-weight:700; color:#b0bec5; letter-spacing:0.1em; text-transform:uppercase; margin:0 0 7px;">Documento (DNI)</p>
                                        <p style="font-size:15px; font-weight:700; color:#1e293b; margin:0;">{{ $athlete->identity_document }}</p>
                                    </div>

                                    <div style="padding:20px 24px; border-right:1.5px solid #f1f5f9;">
                                        <p style="font-size:10px; font-weight:700; color:#b0bec5; letter-spacing:0.1em; text-transform:uppercase; margin:0 0 7px;">Teléfono</p>
                                        <p style="font-size:15px; font-weight:600; color:#1e293b; margin:0;">{{ $athlete->phone ?: 'Sin teléfono' }}</p>
                                    </div>

                                    <div style="padding:20px 24px;">
                                        <p style="font-size:10px; font-weight:700; color:#b0bec5; letter-spacing:0.1em; text-transform:uppercase; margin:0 0 7px;">Ubicación</p>
                                        <p style="font-size:15px; font-weight:600; color:#1e293b; margin:0; text-transform:uppercase;">{{ $athlete->city ?: 'No especificada' }}</p>
                                    </div>

                                </div>
                            </div>

                            {{-- Eventos --}}
                            <div>
                                <div style="display:flex; align-items:center; gap:8px; margin-bottom:10px; padding:0 4px;">
                                    <span style="font-size:11px; font-weight:700; color:#64748b; letter-spacing:0.1em; text-transform:uppercase;">
                                        Evento{{ count($registrations) != 1 ? 's' : '' }} inscripto{{ count($registrations) != 1 ? 's' : '' }}
                                    </span>
                                    <span style="display:inline-flex; align-items:center; justify-content:center; min-width:20px; height:20px; padding:0 6px; border-radius:20px; background:#f1f5f9; font-size:11px; font-weight:700; color:#64748b;">
                                        {{ count($registrations) }}
                                    </span>
                                </div>

                                @if(count($registrations) > 0)
                                    <div style="display:flex; flex-direction:column; gap:10px;">
                                        @foreach($registrations as $reg)
                                            @php $paid = in_array(strtolower($reg->payment_status), ['paid','pagado']); @endphp
                                            <div style="border:1.5px solid #e2e8f0; border-radius:16px; padding:18px 22px; background:#fff; display:flex; align-items:center; justify-content:space-between; gap:16px;">

                                                <div style="display:flex; align-items:center; gap:14px; min-width:0;">
                                                    <div style="flex-shrink:0; width:10px; height:10px; border-radius:50%; background:{{ $paid ? '#22c55e' : '#f97316' }}; box-shadow:0 0 0 4px {{ $paid ? '#dcfce7' : '#ffedd5' }};"></div>
                                                    <div style="min-width:0;">
                                                        <p style="font-size:16px; font-weight:800; color:#000; margin:0; line-height:1.3;">{{ $reg->event->name }}</p>
                                                        <p style="font-size:13px; color:#1e293b; margin:4px 0 0; font-weight:500;">
                                                            {{ $reg->category->name }}
                                                            @if($reg->distance)
                                                                <span style="margin:0 5px; opacity:0.5;">·</span>{{ $reg->distance->name }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>

                                                @if($paid)
                                                    <div style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:20px; background:#f0fdf4; border:1.5px solid #86efac; flex-shrink:0;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="3" stroke-linecap="round"><polyline points="20,6 9,17 4,12"/></svg>
                                                        <span style="font-size:12px; font-weight:700; color:#16a34a; letter-spacing:0.06em; text-transform:uppercase;">Pagado</span>
                                                    </div>
                                                @else
                                                    <div style="display:inline-flex; align-items:center; gap:6px; padding:7px 14px; border-radius:20px; background:#fff7ed; border:1.5px solid #fdba74; flex-shrink:0;">
                                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#ea580c" stroke-width="2.5" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
                                                        <span style="font-size:12px; font-weight:700; color:#ea580c; letter-spacing:0.06em; text-transform:uppercase;">Pendiente</span>
                                                    </div>
                                                @endif

                                            </div>
                                        @endforeach
                                    </div>

                                @else
                                    <div style="border:1.5px solid #e2e8f0; border-radius:16px; padding:36px; text-align:center; background:#f8fafc;">
                                        <div style="width:44px; height:44px; border-radius:12px; background:#f1f5f9; display:flex; align-items:center; justify-content:center; margin:0 auto 12px;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" stroke-linecap="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                        </div>
                                        <p style="font-size:15px; font-weight:600; color:#64748b; margin:0;">Sin inscripciones registradas</p>
                                    </div>
                                @endif
                            </div>

                        </div>

                    @else
                        {{-- No encontrado --}}
                        <div style="border:1.5px solid #fecaca; border-radius:18px; padding:40px; text-align:center; background:#fff;">
                            <div style="width:52px; height:52px; border-radius:50%; background:#fef2f2; border:1.5px solid #fecaca; display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#ef4444" stroke-width="2.5" stroke-linecap="round">
                                    <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                                    <line x1="8" y1="8" x2="14" y2="14"/><line x1="14" y1="8" x2="8" y2="14"/>
                                </svg>
                            </div>
                            <p style="font-size:18px; font-weight:800; color:#0f172a; margin:0 0 8px; letter-spacing:-0.02em;">Atleta no encontrado</p>
                            <p style="font-size:14px; color:#94a3b8; margin:0; font-weight:500; line-height:1.6;">Verificá el documento o nombre ingresado e intentá nuevamente.</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

<style>
@keyframes shimmer {
    0%   { background-position: 200% center; }
    100% { background-position: -200% center; }
}
</style>