#!/bin/bash

PHPMETRICS_DOWNLOAD_URL=https://github.com/PhpMetrics/PhpMetrics/raw/master/build/phpmetrics.phar
PHPMETRICS_APP_PATH=./bin/phpmetrics
PHPMETRICS_REPORT_DESTINATION_PATH=./var/phpmetrics/
ARTIFACTS_PATH=~/artifacts/

function verifyGraphvizIsInstalled() {
    if [ -z `command -v dot` ]; then
        echo "Graphviz (www.graphviz.org) could not be found."
        echo "PhpMetrics uses Graphviz to create visual charts."
        echo "Install Graphviz:"
        echo "brew install graphviz"
        echo "sudo yum install graphviz"
        echo "sudo apt-get install graphviz"
        exit 1
    fi
}

function removePreviousPhpMetricsReport() {
    if [ -d "$PHPMETRICS_REPORT_DESTINATION_PATH" ]; then
        echo -n "Removing existing PhpMetrics report..."
        rm -r "$PHPMETRICS_REPORT_DESTINATION_PATH"
        echo " done."
    fi
}

function downloadPhpMetrics() {
    if [ ! -e "$PHPMETRICS_APP_PATH" ]; then
        echo "Downloading PhpMetrics..."
        wget \
            --output-document=$PHPMETRICS_APP_PATH \
            --tries=5 \
            $PHPMETRICS_DOWNLOAD_URL && \
        chmod +x $PHPMETRICS_APP_PATH
    fi
}

function runPhpMetrics() {
   $PHPMETRICS_APP_PATH
}

function copyPhpMetricsReportFilesToArtifacts() {
    if [ -d "$ARTIFACTS_PATH" ] && [ -d "$PHPMETRICS_REPORT_DESTINATION_PATH" ]; then
        echo -n "Copying PhpMetrics report files to artifacts..."
        cp -r ${PHPMETRICS_REPORT_DESTINATION_PATH}* $ARTIFACTS_PATH
        echo " done."
    fi
}

verifyGraphvizIsInstalled
removePreviousPhpMetricsReport
downloadPhpMetrics
runPhpMetrics
copyPhpMetricsReportFilesToArtifacts
