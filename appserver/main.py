#  ____  _           __       _ _            #
# / ___|| | ___   _ / _| __ _| | | ___ _ __  #
# \___ \| |/ / | | | |_ / _` | | |/ _ \ '_ \ #
#  ___) |   <| |_| |  _| (_| | | |  __/ | | |#
# |____/|_|\_\\__, |_|  \__,_|_|_|\___|_| |_|#
#             |___/                          #
###########################################################################
#                   (C) 2021 - Skyfallen Developers                       #
#                 This file handles the main process                       #
###########################################################################

from processmain import SDCAppServer

if __name__ == '__main__':
    SDCAppServerInstance = SDCAppServer()
    SDCAppServerInstance.HandleAppServer()