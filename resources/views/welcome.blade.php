<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anonymizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
    </style>
</head>
<body class="bg-gray-50 min-h-screen">
    <main class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto bg-white rounded-xl shadow-md overflow-hidden p-6">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-800 mb-2">Anonymizer</h1>
                <p class="text-gray-600">Upload medical documents in DOCX format and get anonymized versions</p>
            </div>

            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center mb-8 bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                <div id="drop-area" class="cursor-pointer">
                    <i data-feather="upload" class="w-12 h-12 mx-auto text-blue-500 mb-4"></i>
                    <h2 class="text-xl font-semibold text-gray-700 mb-2">Drag & Drop Files Here</h2>
                    <p class="text-gray-500 mb-4">or click to select files</p>
                    <input type="file" id="fileInput" class="hidden" multiple accept=".docx">
                    <button id="selectFilesBtn" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg font-medium transition-colors duration-200">
                        Select Files
                    </button>
                </div>
            </div>

            <div id="fileList" class="hidden">
                <h3 class="text-lg font-medium text-gray-700 mb-4">Selected Files</h3>
                <ul id="fileListItems" class="divide-y divide-gray-200">
                    <!-- Files will be listed here -->
                </ul>
                <button id="processBtn" class="mt-6 w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg font-medium transition-colors duration-200 flex items-center justify-center">
                    <i data-feather="refresh-cw" class="w-5 h-5 mr-2"></i>
                    Process and Download Anonymized Files
                </button>
            </div>

            <div id="progressContainer" class="hidden mt-6">
                <div class="flex justify-between mb-2">
                    <span class="text-sm font-medium text-gray-700">Processing...</span>
                    <span id="progressPercent" class="text-sm font-medium text-gray-700">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div id="progressBar" class="bg-blue-500 h-2.5 rounded-full" style="width: 0%"></div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xml-js@1.6.11/dist/xml-js.min.js"></script>

    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            const dropArea = document.getElementById('drop-area');
            const fileInput = document.getElementById('fileInput');
            const selectFilesBtn = document.getElementById('selectFilesBtn');
            const fileList = document.getElementById('fileList');
            const fileListItems = document.getElementById('fileListItems');
            const processBtn = document.getElementById('processBtn');
            const progressContainer = document.getElementById('progressContainer');
            const progressBar = document.getElementById('progressBar');
            const progressPercent = document.getElementById('progressPercent');

            let files = [];

            // Prevent default drag behaviors
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, preventDefaults, false);
            });

            // Highlight drop area when item is dragged over it
            ['dragenter', 'dragover'].forEach(eventName => {
                dropArea.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropArea.addEventListener(eventName, unhighlight, false);
            });

            // Handle dropped files
            dropArea.addEventListener('drop', handleDrop, false);

            // Handle file selection via button
            selectFilesBtn.addEventListener('click', () => fileInput.click());

            // Handle file input change
            fileInput.addEventListener('change', handleFiles);

            // Process files
            processBtn.addEventListener('click', processFiles);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dropArea.classList.add('highlight');
            }

            function unhighlight() {
                dropArea.classList.remove('highlight');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const newFiles = [...dt.files].filter(file => file.name.endsWith('.docx') || file.name.endsWith('.odt'));
                handleFiles({ target: { files: newFiles } });
            }

            function handleFiles(e) {
                const newFiles = [...e.target.files].filter(file => file.name.endsWith('.docx') || file.name.endsWith('.odt'));

                if (newFiles.length === 0) {
                    alert('Please select DOCX files only.');
                    return;
                }

                files = [...files, ...newFiles];
                updateFileList();
            }

            function updateFileList() {
                if (files.length === 0) {
                    fileList.classList.add('hidden');
                    return;
                }

                fileListItems.innerHTML = '';

                files.forEach((file, index) => {
                    const li = document.createElement('li');
                    li.className = 'file-item py-3 px-4 flex justify-between items-center';

                    li.innerHTML = `
                        <div class="flex items-center">
                            <i data-feather="file-text" class="w-5 h-5 text-gray-500 mr-3"></i>
                            <span class="text-gray-700">${file.name}</span>
                        </div>
                        <button class="remove-btn text-red-500 hover:text-red-700" data-index="${index}">
                            <i data-feather="trash-2" class="w-5 h-5"></i>
                        </button>
                    `;

                    fileListItems.appendChild(li);
                });

                // Add event listeners to remove buttons
                document.querySelectorAll('.remove-btn').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        const index = parseInt(e.currentTarget.getAttribute('data-index'));
                        files.splice(index, 1);
                        updateFileList();
                    });
                });

                fileList.classList.remove('hidden');
                feather.replace();
            }

            const getSHA256Hash = async (input) => {
                const textAsBuffer = new TextEncoder().encode(input);
                const hashBuffer = await window.crypto.subtle.digest("SHA-256", textAsBuffer);
                const hashArray = Array.from(new Uint8Array(hashBuffer));
                const hash = hashArray
                    .map((item) => item.toString(16).padStart(2, "0"))
                    .join("");
                return hash;
            };

            function processFiles() {
                if (files.length === 0) return;

                files.forEach(file => {
                    const reader = new FileReader();
                    reader.readAsBinaryString(file);

                    reader.onerror = function (evt) {
                        console.log("error reading file", evt);
                        alert("error reading file" + evt);
                    };
                    reader.onload = function (evt) {
                        const content = evt.target.result;

                        JSZip.loadAsync(content).then(zip => {
                            zip.file("word/document.xml").async("string").then(xmlContent => {
                                const xmlOBJ = xml2js(xmlContent, {compact: true, spaces: 4});
                                console.log(xmlOBJ)
                                let searchTerm = xmlContent.replace(/<[^>]*>/g, '').split("data")[1].split("nat")[0];
                                let lastDotIndex = searchTerm.lastIndexOf('.');

                                if (lastDotIndex > -1) {
                                    searchTerm = searchTerm.substring(lastDotIndex + 1);
                                }

                                searchTerm = searchTerm.trim().replace(",", "")

                                console.log(searchTerm)

                                let nameParts = searchTerm.split(" ")

                                getSHA256Hash(searchTerm).then(replaceTerm => {
                                    const findings = []


                                    // xmlOBJ["w:document"]["w:body"]["w:p"].forEach((paragraph,index) => {
                                    //     let row = paragraph["w:r"]
                                    //     if (row == undefined || !Array.isArray(row)) return

                                    //     nameParts.forEach(part => {
                                    //         const row_index = row.findIndex((word) => {return word?.["w:t"]?.["_text"] == part || word?.["w:t"]?.["_text"] == searchTerm})
                                    //         if(row_index >= 0){
                                    //             findings.push([index, row_index])
                                    //             if(row[row_index]["w:t"]["_text"] == searchTerm){
                                    //                 findings.push([index, row_index+1])
                                    //             }
                                    //         }
                                    //     })
                                    // })

                                    // const merged = findings.reduce((acc, [key, value]) => {
                                    //     if (!acc[key]) acc[key] = [];
                                    //     acc[key].push(value);
                                    //     return acc;
                                    // }, {});

                                    // console.log(merged)

                                    // Object.keys(merged).forEach(paragraph_idx => {
                                    //     let arr = merged[paragraph_idx]
                                    //     arr.sort(function(a, b){return a-b});
                                    //     let start = arr[0]
                                    //     let end = arr[1]

                                    //     xmlOBJ["w:document"]["w:body"]["w:p"][paragraph_idx]["w:r"].splice(start, end - start + 1, {
                                    //         "_attributes": {
                                    //             "w:rsidR": "00EC4CF1",
                                    //             "xml:space": "preserve"
                                    //         },
                                    //         "w:rPr": {
                                    //             "w:rFonts": {
                                    //                 "_attributes": {
                                    //                     "w:ascii": "Times New Roman",
                                    //                     "w:hAnsi": "Times New Roman"
                                    //                 }
                                    //             }
                                    //         },
                                    //         "w:t": {
                                    //             "_text": `${replaceTerm}`
                                    //         }
                                    //     })
                                    // })

                                    // const data = js2xml(xmlOBJ,{compact: true, spaces: 4})
                                    // console.log(data)
                                    // zip.file('word/document.xml', data);

                                    // zip.generateAsync({
                                    //     type: 'blob',
                                    //     // compression: "DEFLATE"
                                    // }).then( blob => {
                                    //     const url = URL.createObjectURL(blob);

                                    //     const a = document.createElement('a');
                                    //     a.style.display = 'none';
                                    //     a.href = url;
                                    //     let yourDate = new Date()

                                    //     a.download = `${replaceTerm}_anonymized_${yourDate.toISOString().split('T')[0]}.docx`

                                    //     document.body.appendChild(a);
                                    //     a.click();

                                    //     document.body.removeChild(a);
                                    //     URL.revokeObjectURL(url);
                                    // });
                                })
                            })

                        })
                    };
                })
            }
        });
    </script>
    <script>
        feather.replace();
    </script>
</body>
</html>
