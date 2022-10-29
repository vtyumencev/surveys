import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();


/**
 * Time updates
 */
timersUpdateAll()

setInterval(() => {
    timersUpdateAll()
}, 5000);

function timersUpdateAll() {
    const timers = document.querySelectorAll('[time-counter-update]')
    const now = Math.floor(new Date().getTime() / 1000);
    timers.forEach(timer => {
        const timestamp = timer.getAttribute('time-counter-update')
        if (timestamp > 0) {
            const diff = now - timestamp;
            if (diff < 10) {
                timer.innerHTML = 'just now'
            } else if (diff < 60) {
                timer.innerHTML = diff + ' seconds ago'
            } else if (diff < 120) {
                timer.innerHTML = 'a minute ago'
            } else if (diff < 3600) {
                timer.innerHTML = Math.floor(diff / 60) + ' minutes ago'
            } else if (diff < 86400) {
                timer.innerHTML = Math.floor(diff / 3600) + ' hours ago'
            }  else if (diff < 2592000) {
                timer.innerHTML = Math.floor(diff / 86400) + ' days ago'
            }
        }
    })
}

/**
 * 
 * 
 */

Livewire.on('draftDeleted', draftID => {
    const draftEl = document.querySelector(`[data-draft-id="${ draftID }"]`)
    draftEl.querySelector('.draft-line-js').classList.add('hidden');
    draftEl.querySelector('.draft-deleted-placeholder-js').classList.remove('hidden')
})

Livewire.on('draftRestored', draftID => {
    const draftEl = document.querySelector(`[data-draft-id="${ draftID }"]`)
    draftEl.querySelector('.draft-line-js').classList.remove('hidden');
    draftEl.querySelector('.draft-deleted-placeholder-js').classList.add('hidden')
})

/**
 * 
 * 
 */

const builderBlocks = (() => {

    let blockBuilderDragging = false;
    let dragbleID = 0
    
    return {
        init: function() {
            const items = document.querySelectorAll('.builder-blocks-buttons .item')
            items.forEach(item => {
                item.addEventListener('dragstart', () => {
                    document.querySelector('.survey-blocks').classList.add('survey-blocks--builder-dragging')
                    dragbleID = item.getAttribute('data-block-id')
                    blockBuilderDragging = true;
                })
                item.addEventListener('dragend', e => {
                    document.querySelector('.survey-blocks').classList.remove('survey-blocks--builder-dragging')
                    blockBuilderDragging = false

                    const prev = document.querySelector('.survey-block.survey-block--fantom') ?? null
                    if (!prev) {
                        return;
                    }

                    const position = [...document.querySelectorAll('.survey-block')].indexOf(prev) + (prev.classList.contains('survey-block--fantom-after') ?? 0)
                    console.log(position)
                    Livewire.emit('newBlockAdded', dragbleID, position)
                    prev.classList.remove('survey-block--fantom')
                })
            })

            document.querySelector('.survey-blocks').addEventListener('dragleave', e => {
                const prev = document.querySelector('.survey-block.survey-block--fantom') ?? null
                if (prev) {
                    prev.classList.remove('survey-block--fantom')
                    prev.classList.remove('survey-block--fantom-after')
                }
            })

            document.querySelector('.survey-blocks').addEventListener('dragover', e => {
                if (!blockBuilderDragging) {
                    return
                }

                e.preventDefault()
                const afterElement = getDragAfterElement(e.clientY)
                const prev = document.querySelector('.survey-block.survey-block--fantom') ?? null
                if (afterElement == prev && afterElement && !afterElement.classList.contains('survey-block--fantom-after')) {
                    return
                }
                if (prev) {
                    prev.classList.remove('survey-block--fantom')
                    prev.classList.remove('survey-block--fantom-after')
                }

                if (afterElement == null) {
                    document.querySelector('.survey-block:last-child').classList.add('survey-block--fantom')
                    document.querySelector('.survey-block:last-child').classList.add('survey-block--fantom-after')
                } else {
                    afterElement.classList.add('survey-block--fantom')
                }
            })
            
            function getDragAfterElement(y) {
                const draggableElements = [...document.querySelectorAll('.survey-block')]

                return draggableElements.reduce((closest, child) => {
                    const box = child.getBoundingClientRect()
                    const offset = y - box.top - box.height / 2
                    if (offset < 0 && offset > closest.offset) {
                        return { offset: offset, element: child }
                    } else {
                        return closest
                    }
                }, { offset: Number.NEGATIVE_INFINITY }).element
            }
        }
    }
})()

builderBlocks.init();
