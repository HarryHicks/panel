{{-- Copyright (c) 2015 - 2016 Dane Everitt <dane@daneeveritt.com> --}}

{{-- Permission is hereby granted, free of charge, to any person obtaining a copy --}}
{{-- of this software and associated documentation files (the "Software"), to deal --}}
{{-- in the Software without restriction, including without limitation the rights --}}
{{-- to use, copy, modify, merge, publish, distribute, sublicense, and/or sell --}}
{{-- copies of the Software, and to permit persons to whom the Software is --}}
{{-- furnished to do so, subject to the following conditions: --}}

{{-- The above copyright notice and this permission notice shall be included in all --}}
{{-- copies or substantial portions of the Software. --}}

{{-- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR --}}
{{-- IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, --}}
{{-- FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE --}}
{{-- AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER --}}
{{-- LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, --}}
{{-- OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE --}}
{{-- SOFTWARE. --}}
<table class="table table-hover" id="file_listing">
    <thead>
        <tr>
            <th style="width:2%;text-align:center;"><i class="fa fa-refresh muted muted-hover use-pointer" data-action="reload-files"></i></th>
            <th style="width:45%">File Name</th>
            <th style="width:15%">Size</th>
            <th style="width:20%">Last Modified</th>
        </tr>
        <tr id="headerTableRow" data-currentdir="{{ $directory['header'] }}">
            <th><i class="fa fa-folder-open"></i></th>
            <th colspan="3">
                <code>/home/container{{ $directory['header'] }}</code>
                <small>
                    <a href="/server/{{ $server->uuidShort }}/files/add/@if($directory['header'] !== '')?dir={{ $directory['header'] }}@endif" class="text-muted">
                        <i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="Add New File(s)"></i>
                    </a>
                </small>
            </th>
        </tr>
    </thead>
    <tbody>
        @if (isset($directory['first']) && $directory['first'] === true)
            <tr data-type="disabled">
                <td><i class="fa fa-folder" style="margin-left: 0.859px;"></i></td>
                <td><a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">&larr;</a></a></td>
                <td></td>
                <td></td>
            </tr>
        @endif
        @if (isset($directory['show']) && $directory['show'] === true)
            <tr data-type="disabled">
                <td><i class="fa fa-folder" style="margin-left: 0.859px;"></i></td>
                <td data-name="{{ rawurlencode($directory['link']) }}">
                    <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">&larr; {{ $directory['link_show'] }}</a>
                </td>
                <td></td>
                <td></td>
            </tr>
        @endif
        @foreach ($folders as $folder)
            <tr class="align-middle" data-type="folder">
                <td data-identifier="type"><i class="fa fa-folder" style="margin-left: 0.859px;"></i></td>
                <td data-identifier="name" data-name="{{ rawurlencode($folder['entry']) }}" data-path="@if($folder['directory'] !== ''){{ rawurlencode($folder['directory']) }}@endif/">
                    <a href="/server/{{ $server->uuidShort }}/files" data-action="directory-view">{{ $folder['entry'] }}</a>
                </td>
                <td data-identifier="size">{{ $folder['size'] }}</td>
                <td data-identifier="modified">{{ date('m/d/y H:i:s', $folder['date']) }}</td>
            </tr>
        @endforeach
        @foreach ($files as $file)
            <tr class="align-middle" data-type="file" data-mime="{{ $file['mime'] }}">
                <td data-identifier="type">
                    {{--  oh boy --}}
                    @if(in_array($file['mime'], [
                        'application/x-7z-compressed',
                        'application/zip',
                        'application/x-compressed-zip',
                        'application/x-tar',
                        'application/x-gzip',
                        'application/x-bzip',
                        'application/x-bzip2',
                        'application/java-archive'
                    ]))
                        <i class="fa fa-file-archive-o" style="margin-left: 2px;"></i>
                    @elseif(in_array($file['mime'], [
                        'application/json',
                        'application/javascript',
                        'application/xml',
                        'application/xhtml+xml',
                        'text/xml',
                        'text/css',
                        'text/html',
                        'text/x-perl',
                        'text/x-shellscript'
                    ]))
                        <i class="fa fa-file-code-o" style="margin-left: 2px;"></i>
                    @elseif(starts_with($file['mime'], 'image'))
                        <i class="fa fa-file-image-o" style="margin-left: 2px;"></i>
                    @elseif(starts_with($file['mime'], 'video'))
                        <i class="fa fa-file-video-o" style="margin-left: 2px;"></i>
                    @elseif(starts_with($file['mime'], 'video'))
                        <i class="fa fa-file-audio-o" style="margin-left: 2px;"></i>
                    @elseif(starts_with($file['mime'], 'application/vnd.ms-powerpoint'))
                        <i class="fa fa-file-powerpoint-o" style="margin-left: 2px;"></i>
                    @elseif(in_array($file['mime'], [
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
                        'application/msword'
                    ]) || starts_with($file['mime'], 'application/vnd.ms-word'))
                        <i class="fa fa-file-word-o" style="margin-left: 2px;"></i>
                    @elseif(in_array($file['mime'], [
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                        'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
                    ]) || starts_with($file['mime'], 'application/vnd.ms-excel'))
                        <i class="fa fa-file-excel-o" style="margin-left: 2px;"></i>
                    @elseif($file['mime'] === 'application/pdf')
                        <i class="fa fa-file-pdf-o" style="margin-left: 2px;"></i>
                    @else
                        <i class="fa fa-file-text-o" style="margin-left: 2px;"></i>
                    @endif
                </td>
                <td data-identifier="name" data-name="{{ rawurlencode($file['entry']) }}" data-path="@if($file['directory'] !== ''){{ rawurlencode($file['directory']) }}@endif/">
                    @if(in_array($file['mime'], $editableMime))
                        @can('edit-files', $server)
                            <a href="/server/{{ $server->uuidShort }}/files/edit/@if($file['directory'] !== ''){{ rawurlencode($file['directory']) }}/@endif{{ rawurlencode($file['entry']) }}" class="edit_file">{{ $file['entry'] }}</a>
                        @else
                            {{ $file['entry'] }}
                        @endcan
                    @else
                        {{ $file['entry'] }}
                    @endif
                </td>
                <td data-identifier="size">{{ $file['size'] }}</td>
                <td data-identifier="modified">{{ date('m/d/y H:i:s', $file['date']) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
