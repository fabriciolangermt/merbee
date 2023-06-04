#!/bin/bash

#
# AWS - neocompany-web-dev (docker)
#
printf "1) Atualizacao RAPIDA (control, database, model, service)\n"
printf "2) Atualizacao COMPLETA\n"
printf "3) Reinstalacao COMPLETA\n"
printf "4) Reinstalacao pasta VENDOR\n"
printf "5) Database\n"
printf "6) Vendor\n"
printf "7) App (Versao)\n"
printf "8) Full (Versao)\n"
read VAR

if [[ $VAR -eq 8 ]]
then
    scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/
fi


# if [[ $VAR -eq 1 ]]
# then
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/control/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/control/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/database/*    ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/database/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/model/*       ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/model/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/service/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/service/
# fi

# if [[ $VAR -eq 2 ]]
# then
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem    /home/fabricio/dev/proj/merbee/src/*.php*            ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem    /home/fabricio/dev/proj/merbee/src/*.xml             ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem    /home/fabricio/dev/proj/merbee/src/*.json            ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/control/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/control/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/database/*    ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/database/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/images/*      ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/images/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/lib/*         ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/lib/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/model/*       ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/model/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/service/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/service/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/resources/*   ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/resources/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/templates/*   ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/templates/
# #    scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/lib/*             ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/lib/
# fi

# if [[ $VAR -eq 3 ]]
# then
    
#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/control/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/control/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/database/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/database/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/lib/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/lib/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/model/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/model/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/service/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/service/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/resources/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/resources/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/app/templates/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/app/templates/*"

#     printf "excluindo pasta /home/ubuntu/app/merbee/src/lib/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/lib/*"

# #    ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/vendor/*"

#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem    /home/fabricio/dev/proj/merbee/src/*.php*            ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem    /home/fabricio/dev/proj/merbee/src/*.xml             ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem    /home/fabricio/dev/proj/merbee/src/*.json            ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/control/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/control/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/database/*    ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/database/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/images/*      ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/images/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/lib/*         ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/lib/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/model/*       ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/model/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/service/*     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/service/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/resources/*   ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/resources/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/templates/*   ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/templates/
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/lib/*             ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/lib/
# #    scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/vendor/*          ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/vendor/
# fi

# if [[ $VAR -eq 4 ]]
# then
#     printf "excluindo pasta /home/ubuntu/app/merbee/src/vendor/* \n"
#     ssh -i "/home/fabricio/dev/aws/neocompany.pem" ubuntu@18.230.15.72 "rm -Rf /home/ubuntu/app/merbee/src/vendor/*"

#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/vendor/*          ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/vendor/
# fi

# if [[ $VAR -eq 5 ]]
# then
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/database/*    ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/database/
# fi

# if [[ $VAR -eq 6 ]]
# then
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/vendor/*          ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/vendor/
# fi

# if [[ $VAR -eq 7 ]]
# then
#     scp -o IdentityFile=/home/fabricio/dev/aws/neocompany.pem -r /home/fabricio/dev/proj/merbee/src/app/control/App.php     ubuntu@18.230.15.72:/home/ubuntu/app/merbee/src/app/control/
# fi
