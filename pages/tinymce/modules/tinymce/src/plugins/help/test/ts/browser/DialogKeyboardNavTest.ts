import { FocusTools, Keys, Mouse } from '@ephox/agar';
import { before, describe, it } from '@ephox/bedrock-client';
import { TinyHooks, TinyUiActions } from '@ephox/mcagar';
import { SugarBody, SugarDocument } from '@ephox/sugar';

import Editor from 'tinymce/core/api/Editor';
import Plugin from 'tinymce/plugins/help/Plugin';
import Theme from 'tinymce/themes/silver/Theme';

describe('browser.tinymce.plugins.help.DialogKeyboardNavTest', () => {
  const hook = TinyHooks.bddSetupLight<Editor>({
    plugins: 'help',
    toolbar: 'help',
    base_url: '/project/tinymce/js/tinymce'
  }, [ Plugin, Theme ], true);

  // Tab key press
  const pressTabKey = (editor: Editor) => TinyUiActions.keydown(editor, Keys.tab());

  // Down arrow key press to nav between tabs
  const pressDownArrowKey = (editor: Editor) => TinyUiActions.keydown(editor, Keys.down());

  // Assert focus is on the expected form element
  const pAssertFocusOnItem = (label: string, selector: string) => FocusTools.pTryOnSelector(
    `Focus should be on: ${label}`,
    SugarDocument.getDocument(),
    selector
  );

  const selectTab = (selector: string) => Mouse.trueClickOn(SugarBody.body(), selector);

  before(() => {
    // Open the help dialog
    hook.editor().execCommand('mceHelp');
  });

  it('TBA: test the tab key navigation cycles through all focusable fields in Handy Shortcuts tab', async () => {
    const editor = hook.editor();
    selectTab('.tox-dialog__body-nav-item:contains("Handy Shortcuts")');
    await pAssertFocusOnItem('Handy Shortcuts Tab', '.tox-dialog__body-nav-item:contains("Handy Shortcuts")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Handy Shortcuts Items', '.tox-dialog__table');
    pressTabKey(editor);
    await pAssertFocusOnItem('Close Button', '.tox-button:contains("Close")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Handy Shortcuts Tab', '.tox-dialog__body-nav-item:contains("Handy Shortcuts")');
    pressDownArrowKey(editor);
  });

  it('TBA: test the tab key navigation cycles through all focusable fields in Keyboard Nav tab', async () => {
    const editor = hook.editor();
    selectTab('.tox-dialog__body-nav-item:contains("Keyboard Navigation")');
    await pAssertFocusOnItem('Keyboard Nav Tab', '.tox-dialog__body-nav-item:contains("Keyboard Navigation")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Installed Plugins', 'div[role="document"]');
    pressTabKey(editor);
    await pAssertFocusOnItem('Close Button', '.tox-button:contains("Close")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Keyboard Nav Tab', '.tox-dialog__body-nav-item:contains("Keyboard Navigation")');
    pressDownArrowKey(editor);
  });

  it('TBA: test the tab key navigation cycles through all focusable fields in Plugins tab', async () => {
    const editor = hook.editor();
    selectTab('.tox-dialog__body-nav-item:contains("Plugins")');
    await pAssertFocusOnItem('Plugins Tab', '.tox-dialog__body-nav-item:contains("Plugins")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Installed Plugins', 'div[role="document"]');
    pressTabKey(editor);
    await pAssertFocusOnItem('Close Button', '.tox-button:contains("Close")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Plugins Tab', '.tox-dialog__body-nav-item:contains("Plugins")');
    pressDownArrowKey(editor);
  });

  it('TBA: test the tab key navigation cycles through all focusable fields in Version tab', async () => {
    const editor = hook.editor();
    selectTab('.tox-dialog__body-nav-item:contains("Version")');
    await pAssertFocusOnItem('Version Tab', '.tox-dialog__body-nav-item:contains("Version")');
    pressTabKey(editor);
    await pAssertFocusOnItem('TinyMCE Version', 'div[role="document"]');
    pressTabKey(editor);
    await pAssertFocusOnItem('Close Button', '.tox-button:contains("Close")');
    pressTabKey(editor);
    await pAssertFocusOnItem('Version Tab', '.tox-dialog__body-nav-item:contains("Version")');
  });
});
