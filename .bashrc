# .bashrc

# Source global definitions
if [ -f /etc/bashrc ]; then
        . /etc/bashrc
fi

alias ls='ls --color=auto'
alias grep='grep --color=auto'

alias l='ls'
alias ll='ls -GFloh'
alias les='less'
alias lsa='ls -la'
alias tailf='tail -f'
alias vi='vim'
alias g='grep'
alias pp='sudo puppetd --no-daemonize -o -v -d'

export PAGER=less
export LESS_TERMCAP_mb=$'\E[01;33m'
export LESS_TERMCAP_md=$'\E[01;31m'
export LESS_TERMCAP_me=$'\E[0m'
export LESS_TERMCAP_so=$'\E[01;42;30m'
export LESS_TERMCAP_se=$'\E[0m'
export LESS_TERMCAP_us=$'\E[01;32m'
export LESS_TERMCAP_ue=$'\E[0m'

# User specific aliases and functions
export HISTCONTROL=erasedups
export HISTSIZE=10000
export HISTTIMEFORMAT='%h %d %H:%M:%S '
shopt -s histappend

export PATH=$PATH:$HOME/bin:/sbin:/usr/sbin
