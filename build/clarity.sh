git subsplit init git@github.com:ps-clarity/framework.git
git subsplit publish --heads="master" src/Clarity:git@github.com:ps-clarity/kernel.git
git subsplit publish --heads="master" src/Clarity/View:git@github.com:ps-clarity/view.git
git subsplit publish --heads="master" src/Clarity/Support:git@github.com:ps-clarity/support.git
git subsplit publish --heads="master" src/Clarity/Contracts:git@github.com:ps-clarity/contracts.git
git subsplit publish --heads="master" src/Clarity/Exceptions:git@github.com:ps-clarity/exceptions.git
rm -rf .subsplit/