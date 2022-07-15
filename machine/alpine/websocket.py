import asyncio
import websockets
import subprocess, shlex
import os
import pathlib

async def execute(websocket):
    async for message in websocket:
        args = shlex.split(message)
        
        print(args)

        if len(args) > 1 and args[0] == "ls":
            getdir = pathlib.Path().resolve()
            os.chdir(args[1])
            output = subprocess.check_output(args, shell=True)
            os.chdir(getdir)
        elif args[0] == "cd":
            os.chdir(args[1])
            output = subprocess.check_output(args, shell=True)
        else:
            #try:
            output = subprocess.check_output(args, shell=True)
            print(str(output).replace('\n', '\r\n'))
            #except:
                #output = str("Command not found: {}".format(args[0])).encode('ascii')

        await websocket.send(str(output.decode("utf-8")).replace('\n', '\r\n'))

async def main():
    async with websockets.serve(execute, "172.22.2.15", 3000):
        await asyncio.Future()  # run forever

asyncio.run(main())
