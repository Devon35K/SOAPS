@extends('user.layout', ['pageTitle' => 'Submit ', 'pageTitleSpan' => 'Documents'])

@section('content')
    <div class="welcome-card" style="margin-bottom: 24px;">
        <h2>Document <span>Submission</span> Room</h2>
        <p>Use this page to upload required clearances, medical certificates, and parental consent forms for the sports unit review.</p>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; color: #166534; padding: 16px; margin-bottom: 24px; border-left: 4px solid #166534; font-weight: 600;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 16px; margin-bottom: 24px; border-left: 4px solid #991b1b; font-weight: 600;">
            {{ session('error') }}
        </div>
    @endif

    <div class="data-table" style="padding: 32px; border-bottom: 4px solid var(--maroon); margin-bottom: 32px;">
        <form method="POST" action="{{ route('user.submissions.store') }}" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 24px; margin-bottom: 24px;">
                
                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Document Type</label>
                    <select name="document_type" class="form-control" required style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                        <option value="" disabled selected>Select the type of document</option>
                        <option value="achievement">Certificate of Achievement / Award</option>
                        <option value="participation">Proof of Participation</option>
                        <option value="medical">Medical Certificate</option>
                        <option value="consent">Parental Consent</option>
                        <option value="waiver">Waiver Form</option>
                        <option value="other">Other Clearances</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-family: 'Barlow Condensed', sans-serif; font-size: 0.8rem; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); margin-bottom: 8px;">Notes (Optional)</label>
                    <input type="text" name="notes" class="form-control" placeholder="Add any details about this document..." style="width: 100%; padding: 12px 16px; border: 2px solid rgba(61,42,47,.12); background: var(--offwhite); outline: none; font-family: 'Barlow', sans-serif; color: var(--charcoal); transition: border-color 0.2s; clip-path: polygon(0 0, calc(100% - 10px) 0, 100% 10px, 100% 100%, 0 100%);">
                </div>
            </div>

            <div id="dropZone" style="border: 2px dashed var(--maroon); background: rgba(122,20,40,0.02); padding: 40px; text-align: center; cursor: pointer; transition: all 0.3s; clip-path: polygon(0 0, calc(100% - 16px) 0, 100% 16px, 100% 100%, 0 100%); margin-bottom: 24px;" onclick="document.getElementById('fileUpload').click()">
                <i class='bx bx-cloud-upload' id="uploadIcon" style="font-size: 3rem; color: var(--maroon); margin-bottom: 12px;"></i>
                <h3 id="uploadText" style="font-family: 'Barlow Condensed', sans-serif; font-size: 1.2rem; color: var(--charcoal);">Drag and drop to upload</h3>
                <p id="uploadSubtext" style="color: var(--text-muted); font-size: 0.9rem;">or click to browse files (PDF, JPG, PNG)</p>
                <input type="file" name="document" id="fileUpload" style="display: none;" onchange="updateFileInfo(this)">
            </div>

            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn btn-primary">
                    <i class='bx bx-upload'></i> Submit Document
                </button>
            </div>
        </form>
    </div>

    <div class="welcome-card" style="margin-bottom: 24px; background: var(--charcoal);">
        <h2 style="color: white;">Submission <span>History</span></h2>
        <p style="color: rgba(255,255,255,0.7);">Track the status of your previously submitted documents.</p>
    </div>

    <div class="data-table" style="overflow: hidden;">
        {{-- Table Header --}}
        <div style="display: grid; grid-template-columns: 3fr 1fr 1.2fr 1fr 0.8fr; gap: 0; background: var(--maroon); padding: 14px 20px; align-items: center;">
            <div style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold);">Document Name</div>
            <div style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold);">Type</div>
            <div style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold);">Date Submitted</div>
            <div style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold);">Status</div>
            <div style="font-family: 'Barlow Condensed', sans-serif; font-size: 0.7rem; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; color: var(--gold); text-align: center;">View</div>
        </div>

        @forelse($submissions as $sub)
            <div style="display: grid; grid-template-columns: 3fr 1fr 1.2fr 1fr 0.8fr; gap: 0; padding: 16px 20px; align-items: center; border-bottom: 1px solid rgba(61,42,47,0.08); transition: background 0.15s;" 
                 onmouseover="this.style.background='rgba(122,20,40,0.03)'" 
                 onmouseout="this.style.background='transparent'">
                
                {{-- Document Name: truncated with tooltip --}}
                <div style="min-width: 0;">
                    <span title="{{ $sub->file_name }}" style="font-weight: 600; font-size: 0.88rem; color: var(--charcoal); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100%;">
                        {{ $sub->file_name }}
                    </span>
                    @if($sub->notes)
                        <span style="font-size: 0.75rem; color: var(--text-muted);">{{ $sub->notes }}</span>
                    @endif
                </div>

                {{-- Type --}}
                <div style="font-size: 0.85rem; color: var(--text-body);">
                    {{ ucfirst($sub->document_type) }}
                </div>

                {{-- Date --}}
                <div style="font-size: 0.85rem; color: var(--text-muted);">
                    {{ $sub->submission_date->format('M d, Y') }}
                </div>

                {{-- Status Badge --}}
                <div>
                    @if($sub->status === 'approved')
                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 5px 10px; font-family: 'Barlow Condensed'; background: #dcfce7; color: #166534; border-radius: 2px;">
                            <i class='bx bx-check-circle'></i> Approved
                        </span>
                    @elseif($sub->status === 'rejected')
                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 5px 10px; font-family: 'Barlow Condensed'; background: #fee2e2; color: #991b1b; border-radius: 2px;">
                            <i class='bx bx-x-circle'></i> Rejected
                        </span>
                    @else
                        <span style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 1px; font-weight: 800; padding: 5px 10px; font-family: 'Barlow Condensed'; background: #fef9c3; color: #854d0e; border-radius: 2px;">
                            <i class='bx bx-time-five'></i> Pending
                        </span>
                    @endif
                </div>

                {{-- View Button --}}
                <div style="text-align: center;">
                    <a href="{{ route('user.submissions.view', $sub->id) }}" target="_blank"
                       style="display: inline-flex; align-items: center; gap: 4px; font-size: 0.75rem; font-family: 'Barlow Condensed'; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; color: var(--maroon); text-decoration: none; padding: 5px 10px; border: 1.5px solid var(--maroon); transition: all 0.2s;"
                       onmouseover="this.style.background='var(--maroon)';this.style.color='white';"
                       onmouseout="this.style.background='transparent';this.style.color='var(--maroon)';">
                        <i class='bx bx-show'></i> View
                    </a>
                </div>
            </div>
        @empty
            <div style="padding: 60px 20px; text-align: center; color: var(--text-muted);">
                <i class='bx bx-folder-open' style="font-size: 3rem; display: block; margin-bottom: 12px; opacity: 0.4;"></i>
                <p style="font-family: 'Barlow Condensed'; font-size: 1rem; text-transform: uppercase; letter-spacing: 1px;">No submissions found.</p>
            </div>
        @endforelse
    </div>

    <script>
    function updateFileInfo(input) {
        if (input.files && input.files[0]) {
            const fileName = input.files[0].name;
            document.getElementById('uploadText').innerText = "Selected: " + fileName;
            document.getElementById('uploadSubtext').innerText = "Click to change file";
            document.getElementById('uploadIcon').className = 'bx bx-check-circle';
            document.getElementById('uploadIcon').style.color = '#10B981';
            document.getElementById('dropZone').style.borderColor = '#10B981';
            document.getElementById('dropZone').style.background = 'rgba(16,185,129,0.02)';
        }
    }
    </script>
@endsection
