git subsplit init git@github.com:phalconslayer/framework.git
git subsplit publish --heads="master 1.3" src/Clarity/Console:git@github.com:ps-clarity/console.git
git subsplit publish --heads="master 1.3" src/Clarity/Contracts:git@github.com:ps-clarity/contracts.git
git subsplit publish --heads="master 1.3" src/Clarity/Exceptions:git@github.com:ps-clarity/exceptions.git
git subsplit publish --heads="master 1.3" src/Clarity/Facades:git@github.com:ps-clarity/facades.git
git subsplit publish --heads="master 1.3" src/Clarity/Kernel:git@github.com:ps-clarity/kernel.git
git subsplit publish --heads="master 1.3" src/Clarity/Lang:git@github.com:ps-clarity/lang.git
git subsplit publish --heads="master 1.3" src/Clarity/Mail:git@github.com:ps-clarity/mail.git
git subsplit publish --heads="master 1.3" src/Clarity/Providers:git@github.com:ps-clarity/providers.git
git subsplit publish --heads="master 1.3" src/Clarity/Services:git@github.com:ps-clarity/services.git
git subsplit publish --heads="master 1.3" src/Clarity/Support:git@github.com:ps-clarity/support.git
git subsplit publish --heads="master 1.3" src/Clarity/Util:git@github.com:ps-clarity/util.git
git subsplit publish --heads="master 1.3" src/Clarity/TestSuite:git@github.com:ps-clarity/test-suite.git
git subsplit publish --heads="master 1.3" src/Clarity/View:git@github.com:ps-clarity/view.git

rm -rf .subsplit/