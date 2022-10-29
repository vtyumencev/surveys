<div>
    <div class="text-editor p-2 border rounded-md shadow-sm border-gray-300" wire:ignore>
        <div class="tinymce-editor" id="blockEditor{{ $block->id }}">
            {!! $block->content !!}
        </div>
        <textarea wire:model.debounce.5s="block.content" class="text-editor-textarea hidden"></textarea>
    </div>
    <script>
        const blockEditor{{ $block->id }} = tinymce.init({
            selector: '#blockEditor{{ $block->id }}',
            menubar: false,
            inline: true,
            plugins: [
                'lists',
                'link',
                'autolink',
            ],
            toolbar: 'undo redo | bold italic underline link | backcolor | numlist bullist | alignleft aligncenter',
            valid_elements: 'p[style],strong,em,span[style],a[href],ul,ol,li',
            valid_styles: {
                '*': 'font-size,font-family,color,text-decoration,text-align'
            },
            powerpaste_word_import: 'clean',
            powerpaste_html_import: 'clean',
            hidden_input: false,
            setup: (editor) => {
                editor.on('Paste Change input Undo Redo', (e) => {
                    const content = document.getElementById('blockEditor{{ $block->id }}').innerHTML
                    @this.set('block.content', content)
                });
            }
        })
    </script>
</div>
