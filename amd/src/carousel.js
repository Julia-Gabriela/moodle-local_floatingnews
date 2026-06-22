// This file is part of Moodle - http://moodle.org/

/**
 * Floating carousel behaviour for local_floatingnews.
 *
 * @module     local_floatingnews/carousel
 * @copyright  2026 Julia Gabriela Gomes da Silva
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define([], function() {
    /**
     * Try to add a simple shortcut to the theme top navigation.
     * This is intentionally defensive because themes expose different menus.
     *
     * @param {Object} config Runtime configuration.
     */
    function addManageShortcut(config) {
        if (!config.canmanage || !config.manageurl || document.querySelector('[data-local-floatingnews-shortcut="1"]')) {
            return;
        }

        var label = config.menulabel || 'Floating News';
        var containers = Array.prototype.slice.call(document.querySelectorAll(
            '.primary-navigation .navbar-nav, .navbar .navbar-nav, .navbar-nav, .nav'
        ));

        if (!containers.length) {
            return;
        }

        var adminAnchor = null;
        var anchors = Array.prototype.slice.call(document.querySelectorAll('a'));
        anchors.some(function(anchor) {
            var text = (anchor.textContent || '').replace(/\s+/g, ' ').trim().toLowerCase();
            var href = anchor.getAttribute('href') || '';
            if (text.indexOf('administração do site') !== -1 || text.indexOf('administracao do site') !== -1 ||
                    text.indexOf('site administration') !== -1 || href.indexOf('/admin/') !== -1) {
                adminAnchor = anchor;
                return true;
            }
            return false;
        });

        var container = null;
        var insertAfter = null;

        if (adminAnchor) {
            containers.some(function(candidate) {
                if (candidate.contains(adminAnchor)) {
                    container = candidate;
                    return true;
                }
                return false;
            });

            if (container) {
                insertAfter = adminAnchor.closest ? adminAnchor.closest('li') : null;
                if (!insertAfter || !container.contains(insertAfter)) {
                    insertAfter = adminAnchor.parentNode;
                }
            }
        }

        if (!container) {
            container = containers[0];
        }

        var li = document.createElement('li');
        li.className = 'nav-item local-floatingnews-navitem';
        li.setAttribute('data-local-floatingnews-shortcut', '1');

        var link = document.createElement('a');
        link.className = 'nav-link local-floatingnews-navlink';
        link.href = config.manageurl;
        link.textContent = label;
        li.appendChild(link);

        if (insertAfter && insertAfter.parentNode === container && insertAfter.nextSibling) {
            container.insertBefore(li, insertAfter.nextSibling);
        } else if (insertAfter && insertAfter.parentNode === container) {
            container.appendChild(li);
        } else {
            container.appendChild(li);
        }
    }

    return {
        init: function(config) {
            config = config || {};
            addManageShortcut(config);

            var panel = document.getElementById('local-floatingnews-panel');
            var tab = document.getElementById('local-floatingnews-tab');
            if (!panel || !tab) {
                return;
            }

            var itemsContainer = panel.querySelector('.local-floatingnews-items');
            var items = Array.prototype.slice.call(panel.querySelectorAll('.local-floatingnews-item'));
            var dots = Array.prototype.slice.call(panel.querySelectorAll('.local-floatingnews-dot'));
            var close = panel.querySelector('.local-floatingnews-close');
            var interval = parseInt(config.interval || 5000, 10);
            var layout = config.layout || panel.getAttribute('data-layout') || 'fade';
            var pauseOnHover = config.pauseonhover !== false && config.pauseonhover !== 0;
            var rememberClose = config.rememberclose !== false && config.rememberclose !== 0;
            var startCollapsed = config.startcollapsed === true || config.startcollapsed === 1;
            var current = 0;
            var timer = null;
            var wheelLocked = false;
            var storageKey = 'local_floatingnews_collapsed';

            function resetTransform() {
                if (itemsContainer) {
                    itemsContainer.style.transform = '';
                }
            }

            function syncHeight() {
                if (!itemsContainer || !items.length) {
                    return;
                }

                if (layout === 'slide') {
                    itemsContainer.style.height = Math.max(items[current].offsetHeight, 180) + 'px';
                } else if (layout === 'ticker') {
                    itemsContainer.style.height = Math.max(items[current].offsetHeight, 180) + 'px';
                } else if (layout === 'feed') {
                    itemsContainer.style.height = '';
                } else {
                    itemsContainer.style.height = '';
                }
            }

            function show(index) {
                if (!items.length) {
                    return;
                }

                current = ((index % items.length) + items.length) % items.length;

                items.forEach(function(item, itemIndex) {
                    item.classList.toggle('is-active', itemIndex === current);
                });
                dots.forEach(function(dot, dotIndex) {
                    dot.classList.toggle('is-active', dotIndex === current);
                });

                if (!itemsContainer) {
                    return;
                }

                if (layout === 'slide') {
                    itemsContainer.style.transform = 'translateX(-' + (current * 100) + '%)';
                } else {
                    resetTransform();
                }

                syncHeight();
            }

            function start() {
                if (items.length <= 1 || layout === 'feed') {
                    return;
                }
                stop();
                timer = window.setInterval(function() {
                    show(current + 1);
                }, Math.max(interval, 1500));
            }

            function stop() {
                if (timer) {
                    window.clearInterval(timer);
                    timer = null;
                }
            }

            function setCollapsed(collapsed) {
                document.documentElement.classList.toggle('local-floatingnews-is-collapsed', collapsed);
                if (rememberClose) {
                    try {
                        window.sessionStorage.setItem(storageKey, collapsed ? '1' : '0');
                    } catch (error) {
                        // Ignore storage errors.
                    }
                }
            }

            dots.forEach(function(dot) {
                dot.addEventListener('click', function() {
                    show(parseInt(dot.getAttribute('data-index'), 10));
                    start();
                });
            });

            if (pauseOnHover) {
                panel.addEventListener('mouseenter', stop);
                panel.addEventListener('mouseleave', start);
            }

            if (layout === 'ticker') {
                panel.addEventListener('wheel', function(event) {
                    if (items.length <= 1 || wheelLocked) {
                        return;
                    }
                    event.preventDefault();
                    wheelLocked = true;
                    stop();
                    show(current + (event.deltaY >= 0 ? 1 : -1));
                    window.setTimeout(function() {
                        wheelLocked = false;
                    }, 420);
                    start();
                }, {passive: false});
            }

            if (close) {
                close.addEventListener('click', function() {
                    setCollapsed(true);
                });
            }

            tab.addEventListener('click', function() {
                setCollapsed(false);
            });

            var restored = false;
            if (rememberClose) {
                try {
                    if (window.sessionStorage.getItem(storageKey) === '1') {
                        setCollapsed(true);
                        restored = true;
                    }
                } catch (error) {
                    // Ignore storage errors.
                }
            }

            if (!restored && startCollapsed) {
                setCollapsed(true);
            }

            window.addEventListener('resize', function() {
                show(current);
            });

            show(0);
            start();
        }
    };
});
