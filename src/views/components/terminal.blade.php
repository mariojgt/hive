<div>
    <div id="vanilla-terminal"></div>
</div>

@push('js')
    <script src="{{ asset('vendor/Hive/js/vanilla-terminal.js') }}"></script>

    <script>
        const term = new VanillaTerminal({
          commands: {
            flavour: (terminal) => {
              terminal.output('There is only one flavour for your favorite🍦and it is <b>vanilla<b>.')
              terminal.setPrompt('@soyjavi <small>❤️</small> <u>vanilla</u> ');
            },

            user: (terminal) => {
                terminal.output('Type User your_name')
            },

            async: (terminal) => {
              terminal.idle();
              setTimeout(() => terminal.output('Async 300'), 300);
              setTimeout(() => terminal.output('Async 1300'), 1300);
              setTimeout(() => {
                terminal.output('Async 2000');
                terminal.setPrompt();
              }, 2000);
            },
          },

          // welcome: 'Welcome...',
          // prompt: 'soyjavi at <u>Macbook-Pro</u> ',
          separator: '$',
        });

        term.onInput((command, parameters) => {
          console.log('⚡️onInput', command, parameters);

          // Simple console interaction
          if (command == 'user') {
            term.setPrompt(`${parameters} `);
          }
        });

        // Load Terminal data
        term.output(`{!! $terminalData !!}`);

        // Grettings
        // term.prompt('Your name', (name) => {
        //   term.output(`Hi ${name}!`);
        //   term.setPrompt(`${name} `);
        // });
      </script>
@endpush
