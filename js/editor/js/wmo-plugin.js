$.FroalaEditor.DefineIcon('dropdownIcon', { NAME: 'magic'}),

// Define a dropdown button.
$.FroalaEditor.RegisterCommand('myDropdown', {
    // Button title.
    title: 'My Dropdown',

    // Mark the button as a dropdown.
    type: 'dropdown',

    // Specify the icon for the button.
    // If this option is not specified, the button name will be used.
    icon: 'dropdownIcon',

    // Options for the dropdown.
    options: {
        'H1': 'Option 1',
        'H2': 'Option 2'
    },
    // Save the dropdown action into undo stack.
    undo: true,

    // Focus inside the editor before callback.
    focus: true,

    // Refresh the button state after the callback.
    refreshAfterCallback: true,

    // Callback.
    callback: function (cmd, val, params) {
        var text = this.html.getSelected;
        this.paragraphFormat.apply('H2');
        // The current context is the editor instance.
        console.log (this.html.getSelected);

    },

    // Called when the dropdown button state might have changed.
    refresh: function ($btn) {
        // The current context is the editor instance.
        console.log (this.selection.element());
    },

    // Called when the dropdown is shown.
    refreshOnShow: function ($btn, $dropdown) {
        // The current context is the editor instance.
        console.log (this.selection.element());
    }
})