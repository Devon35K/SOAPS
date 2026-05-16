@extends('user.layout', ['pageTitle' => 'Track ', 'pageTitleSpan' => 'Records'])

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px;">
        <h2>My <span>Transmission</span> History</h2>
        <p>Review the approval status of your past document submissions and evaluation forms.</p>
    </div>

    <div class="data-table">
        <div class="table-header" style="display: flex; align-items: center; padding: 12px 24px;">
            <div style="flex: 3; min-width: 0;">Document Name</div>
            <div style="flex: 1.2; text-align: center;">Date Submitted</div>
            <div style="flex: 1; text-align: center;">Status</div>
            <div style="flex: 1; text-align: center;">Action</div>
        </div>
        
        @forelse($submissions as $sub)
            @php
                $ext = pathinfo($sub->file_name, PATHINFO_EXTENSION);
                $iconClass = 'bxs-file-blank';
                $iconColor = '#64748b';
                $bgIcon = 'rgba(100,116,139,0.1)';

                if(in_array($ext, ['jpg', 'jpeg', 'png'])) {
                    $iconClass = 'bxs-file-image';
                    $iconColor = '#3b82f6';
                    $bgIcon = 'rgba(59,130,246,0.1)';
                } elseif($ext === 'pdf') {
                    $iconClass = 'bxs-file-pdf';
                    $iconColor = '#ef4444';
                    $bgIcon = 'rgba(239,68,68,0.1)';
                }
            @endphp
            <div class="table-row" style="display: flex; align-items: center; padding: 12px 24px;">
                <div style="flex: 3; display: flex; align-items: center; gap: 12px; min-width: 0;">
                    <div style="width: 32px; height: 32px; background: {{ $bgIcon }}; color: {{ $iconColor }}; border-radius: 4px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class='bx {{ $iconClass }}'></i>
                    </div>
                    <span style="font-weight: 600; color: var(--text-body); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $sub->file_name }}">
                        {{ $sub->file_name }}
                    </span>
                </div>
                <div style="flex: 1.2; font-size: 0.9rem; color: var(--text-muted); text-align: center;">{{ $sub->submission_date->format('M d, Y') }}</div>
                <div style="flex: 1; text-align: center;">
                    <span style="
                        @if($sub->status === 'approved') background: rgba(16,185,129,0.1); color: #059669; border: 1px solid rgba(16,185,129,0.2);
                        @elseif($sub->status === 'rejected') background: rgba(239,68,68,0.1); color: #B91C1C; border: 1px solid rgba(239,68,68,0.2);
                        @else background: rgba(240,180,41,0.1); color: var(--gold-dark); border: 1px solid rgba(240,180,41,0.2);
                        @endif
                        padding: 4px 10px; border-radius: 3px; font-family: 'Barlow Condensed'; font-weight: 700; font-size: 0.75rem; letter-spacing: 1px; text-transform: uppercase;">
                        {{ ucfirst($sub->status) }}
                    </span>
                </div>
                <div style="flex: 1; text-align: center;">
                    <button type="button" 
                            onclick="openViewModal('{{ route('user.submissions.view', $sub->id) }}', '{{ $ext }}')" 
                            class="btn btn-outline" style="padding: 6px 14px; font-size: 0.75rem; display: inline-flex; align-items: center; gap: 4px; border-radius: 4px;">
                        <i class='bx bx-show'></i> VIEW
                    </button>
                </div>
            </div>
        @empty
            <div style="padding: 40px; text-align: center; color: var(--text-muted); font-weight: 500;">
                No transmission history found.
            </div>
        @endforelse
    </div>

    <!-- Document View Modal (Hidden by default, will be moved to body) -->
    <div id="documentViewModal" style="position: fixed; inset: 0; background: rgba(15, 12, 12, 0.85); backdrop-filter: blur(5px); display: none; align-items: center; justify-content: center; z-index: 999999;">
        <div style="background: white; width: 95%; max-width: 1200px; height: 90vh; position: relative; display: flex; flex-direction: column; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); clip-path: polygon(0 0, calc(100% - 20px) 0, 100% 20px, 100% 100%, 0 100%);">
            <!-- Header -->
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 28px; background: #fff; border-bottom: 2px solid #f1f5f9;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 8px; height: 24px; background: var(--maroon);"></div>
                    <h3 style="font-family: 'Barlow Condensed'; font-weight: 800; font-size: 1.4rem; color: var(--charcoal); margin: 0; text-transform: uppercase; letter-spacing: 0.5px;">Document Preview</h3>
                </div>
                <button onclick="closeViewModal()" style="background: #f1f5f9; border: none; width: 36px; height: 36px; border-radius: 4px; font-size: 1.5rem; color: #ef4444; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#fee2e2'" onmouseout="this.style.background='#f1f5f9'">
                    <i class='bx bx-x'></i>
                </button>
            </div>
            <!-- Body -->
            <div id="documentPreviewContent" style="flex: 1; overflow: hidden; background: #333; display: flex; align-items: center; justify-content: center;">
                <!-- Content will be injected here -->
            </div>
        </div>
    </div>

    <script>
    // Move modal to body to prevent z-index/layout issues with parent containers
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('documentViewModal');
        document.body.appendChild(modal);
    });

    function openViewModal(url, extension) {
        const modal = document.getElementById('documentViewModal');
        const container = document.getElementById('documentPreviewContent');
        
        container.innerHTML = '';
        
        if (['jpg', 'jpeg', 'png', 'gif'].includes(extension.toLowerCase())) {
            const img = document.createElement('img');
            img.src = url;
            img.style.width = '100%';
            img.style.maxWidth = '800px';
            img.style.height = 'auto';
            img.style.flexShrink = '0'; // Prevent squeezing
            img.style.display = 'block';
            img.style.boxShadow = '0 20px 25px -5px rgba(0, 0, 0, 0.5)';
            img.style.border = '1px solid rgba(255,255,255,0.1)';
            img.style.borderRadius = '4px';
            img.style.marginBottom = '40px'; // Extra space at bottom
            
            container.style.background = '#1a1a1a';
            container.style.padding = '40px 20px';
            container.style.overflowY = 'auto';
            container.style.display = 'flex';
            container.style.flexDirection = 'column';
            container.style.alignItems = 'center';
            container.style.justifyContent = 'flex-start'; // Start from top
            container.appendChild(img);
        } else {
            const iframe = document.createElement('iframe');
            iframe.src = url;
            iframe.style.width = '100%';
            iframe.style.height = '100%';
            iframe.style.border = 'none';
            container.style.background = '#333';
            container.style.padding = '0';
            container.appendChild(iframe);
        }
        
        modal.style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }

    function closeViewModal() {
        document.getElementById('documentViewModal').style.display = 'none';
        document.getElementById('documentPreviewContent').innerHTML = '';
        document.body.style.overflow = 'auto';
    }
    </script>
@endsection
